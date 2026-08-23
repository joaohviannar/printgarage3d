<?php

namespace App\Services;

use App\Exceptions\EstoqueInsuficienteException;
use App\Models\MovimentacaoEstoque;
use App\Models\Produto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Camada de servico que centraliza toda a logica de movimentacao de estoque
 * de produtos. Cada operacao e atomica (DB::transaction + lockForUpdate)
 * e gera registro auditavel em movimentacoes_estoque.
 *
 * Origens validas (alinhadas com o enum da migration):
 *   - venda             saida automatica por ItemVenda criado
 *   - producao          entrada manual (produto produzido)
 *   - ajuste_manual     ajuste explicito feito pelo admin
 *   - perda             saida por perda/quebra
 *   - venda_cancelada   entrada por cancelamento de venda
 */
class EstoqueService
{
    /**
     * Da baixa no estoque de um produto.
     *
     * @throws EstoqueInsuficienteException quando nao ha quantidade disponivel
     */
    public function darBaixa(
        Produto $produto,
        int $quantidade,
        string $origem,
        ?int $referenciaId = null,
        ?int $userId = null,
        ?string $observacao = null,
    ): ?MovimentacaoEstoque {
        if ($quantidade <= 0) {
            throw new \InvalidArgumentException('Quantidade deve ser positiva.');
        }

        // Produto sob encomenda nao tem peca pronta: a impressao comeca depois
        // da venda. Nao ha o que baixar nem estoque minimo a respeitar.
        if (! $produto->controlaEstoque()) {
            return null;
        }

        return DB::transaction(function () use ($produto, $quantidade, $origem, $referenciaId, $userId, $observacao) {
            // Lock pessimista para evitar race condition em vendas simultaneas
            $produto = Produto::lockForUpdate()->findOrFail($produto->id);

            if ($produto->estoque_atual < $quantidade) {
                throw new EstoqueInsuficienteException($produto, $quantidade, $produto->estoque_atual);
            }

            $anterior = $produto->estoque_atual;
            $posterior = $anterior - $quantidade;

            $produto->update(['estoque_atual' => $posterior]);

            return MovimentacaoEstoque::create([
                'produto_id'        => $produto->id,
                'tipo'              => 'saida',
                'quantidade'        => $quantidade,
                'estoque_anterior'  => $anterior,
                'estoque_posterior' => $posterior,
                'origem'            => $origem,
                'referencia_id'     => $referenciaId,
                'user_id'           => $userId ?? Auth::id() ?? 1,
                'observacao'        => $observacao,
            ]);
        });
    }

    /**
     * Devolve quantidade ao estoque (entrada). Usado em cancelamento de venda,
     * producao, ajustes positivos, etc.
     */
    public function devolver(
        Produto $produto,
        int $quantidade,
        string $origem,
        ?int $referenciaId = null,
        ?int $userId = null,
        ?string $observacao = null,
    ): ?MovimentacaoEstoque {
        if ($quantidade <= 0) {
            throw new \InvalidArgumentException('Quantidade deve ser positiva.');
        }

        // Simetrico ao darBaixa: se nao houve baixa, nao pode haver devolucao —
        // do contrario cancelar uma venda criaria estoque fantasma.
        if (! $produto->controlaEstoque()) {
            return null;
        }

        return DB::transaction(function () use ($produto, $quantidade, $origem, $referenciaId, $userId, $observacao) {
            $produto = Produto::lockForUpdate()->findOrFail($produto->id);

            $anterior = $produto->estoque_atual;
            $posterior = $anterior + $quantidade;

            $produto->update(['estoque_atual' => $posterior]);

            return MovimentacaoEstoque::create([
                'produto_id'        => $produto->id,
                'tipo'              => 'entrada',
                'quantidade'        => $quantidade,
                'estoque_anterior'  => $anterior,
                'estoque_posterior' => $posterior,
                'origem'            => $origem,
                'referencia_id'     => $referenciaId,
                'user_id'           => $userId ?? Auth::id() ?? 1,
                'observacao'        => $observacao,
            ]);
        });
    }

    /**
     * Ajusta o estoque para um valor absoluto (definido pelo admin).
     * Registra como 'ajuste' com diferenca positiva ou negativa.
     */
    public function ajustarManual(
        Produto $produto,
        int $novaQuantidade,
        ?int $userId = null,
        ?string $observacao = null,
    ): MovimentacaoEstoque {
        if ($novaQuantidade < 0) {
            throw new \InvalidArgumentException('Estoque nao pode ser negativo.');
        }

        return DB::transaction(function () use ($produto, $novaQuantidade, $userId, $observacao) {
            $produto = Produto::lockForUpdate()->findOrFail($produto->id);

            $anterior = $produto->estoque_atual;
            $diferenca = $novaQuantidade - $anterior;

            $produto->update(['estoque_atual' => $novaQuantidade]);

            return MovimentacaoEstoque::create([
                'produto_id'        => $produto->id,
                'tipo'              => 'ajuste',
                'quantidade'        => abs($diferenca),
                'estoque_anterior'  => $anterior,
                'estoque_posterior' => $novaQuantidade,
                'origem'            => 'ajuste_manual',
                'user_id'           => $userId ?? Auth::id() ?? 1,
                'observacao'        => $observacao,
            ]);
        });
    }
}
