<?php

namespace App\Observers;

use App\Models\Venda;
use App\Services\EstoqueService;
use Illuminate\Support\Facades\DB;

/**
 * Observer das vendas - trata o cancelamento devolvendo todos os itens ao estoque.
 *
 * - updated: detecta mudanca de status para 'cancelado' e devolve cada item
 *   ao estoque registrando origem=venda_cancelada.
 */
class VendaObserver
{
    public function __construct(private readonly EstoqueService $estoque)
    {
    }

    /**
     * Detecta cancelamento via mudanca de status.
     */
    public function updated(Venda $venda): void
    {
        if (!$venda->wasChanged('status')) {
            return;
        }

        $statusAnterior = $venda->getOriginal('status');
        $statusNovo     = $venda->status;

        // Caso 1: passou para cancelado -> devolve estoque
        if ($statusNovo === 'cancelado' && $statusAnterior !== 'cancelado') {
            $this->devolverEstoqueDaVenda($venda);
        }

        // Caso 2: saiu de cancelado para pago/pendente -> baixa estoque de novo
        if ($statusAnterior === 'cancelado' && $statusNovo !== 'cancelado') {
            $this->refazerBaixaDaVenda($venda);
        }
    }

    private function devolverEstoqueDaVenda(Venda $venda): void
    {
        DB::transaction(function () use ($venda) {
            foreach ($venda->itens as $item) {
                $this->estoque->devolver(
                    produto:       $item->produto,
                    quantidade:    $item->quantidade,
                    origem:        'venda_cancelada',
                    referenciaId:  $venda->id,
                    observacao:    "Cancelamento da venda #{$venda->id}",
                );
            }
        });
    }

    private function refazerBaixaDaVenda(Venda $venda): void
    {
        DB::transaction(function () use ($venda) {
            foreach ($venda->itens as $item) {
                $this->estoque->darBaixa(
                    produto:       $item->produto,
                    quantidade:    $item->quantidade,
                    origem:        'venda',
                    referenciaId:  $venda->id,
                    observacao:    "Venda #{$venda->id} reativada",
                );
            }
        });
    }
}
