<?php

namespace App\Exceptions;

use App\Models\Produto;
use RuntimeException;

/**
 * Lancada quando ha tentativa de dar baixa em produto sem estoque suficiente.
 */
class EstoqueInsuficienteException extends RuntimeException
{
    public function __construct(
        public readonly Produto $produto,
        public readonly int $solicitado,
        public readonly int $disponivel,
    ) {
        $mensagem = sprintf(
            'Estoque insuficiente para "%s". Solicitado: %d, disponível: %d.',
            $produto->nome,
            $solicitado,
            $disponivel,
        );

        parent::__construct($mensagem);
    }
}
