<?php

namespace App\Observers;

use App\Models\ItemVenda;
use App\Services\EstoqueService;

/**
 * Observer dos itens de venda - faz toda a movimentacao automatica de estoque
 * quando itens sao adicionados, alterados ou removidos de uma venda.
 *
 * - created: da baixa no estoque (saida com origem=venda)
 * - updated: recalcula a diferenca de quantidade entre original e novo
 * - deleted: devolve a quantidade ao estoque
 */
class ItemVendaObserver
{
    public function __construct(private readonly EstoqueService $estoque)
    {
    }

    /**
     * Ao criar um item, da baixa no estoque.
     */
    public function created(ItemVenda $item): void
    {
        // Nao mexer no estoque se a venda ja esta cancelada (caso raro)
        if ($item->venda && $item->venda->status === 'cancelado') {
            return;
        }

        $this->estoque->darBaixa(
            produto:       $item->produto,
            quantidade:    $item->quantidade,
            origem:        'venda',
            referenciaId:  $item->venda_id,
            observacao:    "Venda #{$item->venda_id}",
        );
    }

    /**
     * Ao atualizar quantidade do item, ajusta a diferenca.
     * Ex: tinha 3 e mudou para 5 -> baixar mais 2.
     *     tinha 5 e mudou para 3 -> devolver 2.
     */
    public function updated(ItemVenda $item): void
    {
        // So importa se a quantidade mudou
        if (!$item->wasChanged('quantidade')) {
            return;
        }

        $original = (int) $item->getOriginal('quantidade');
        $novo     = (int) $item->quantidade;
        $delta    = $novo - $original;

        if ($delta === 0) {
            return;
        }

        if ($delta > 0) {
            // Aumentou a quantidade: baixar a diferenca
            $this->estoque->darBaixa(
                produto:       $item->produto,
                quantidade:    $delta,
                origem:        'venda',
                referenciaId:  $item->venda_id,
                observacao:    "Venda #{$item->venda_id} (ajuste +{$delta})",
            );
        } else {
            // Diminuiu a quantidade: devolver a diferenca
            $this->estoque->devolver(
                produto:       $item->produto,
                quantidade:    abs($delta),
                origem:        'venda',
                referenciaId:  $item->venda_id,
                observacao:    "Venda #{$item->venda_id} (ajuste {$delta})",
            );
        }
    }

    /**
     * Ao deletar um item, devolve o estoque (a menos que a venda esteja sendo cancelada,
     * pois o VendaObserver ja cuida disso).
     */
    public function deleted(ItemVenda $item): void
    {
        // Se a venda esta sendo cancelada/deletada, o VendaObserver cuida disso
        if ($item->venda && in_array($item->venda->status, ['cancelado'])) {
            return;
        }

        $this->estoque->devolver(
            produto:       $item->produto,
            quantidade:    $item->quantidade,
            origem:        'venda',
            referenciaId:  $item->venda_id,
            observacao:    "Venda #{$item->venda_id} (item removido)",
        );
    }
}
