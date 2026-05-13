<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Insumo extends Model
{
    protected $table = 'insumos';

    protected $fillable = [
        'nome',
        'tipo',
        'cor',
        'marca',
        'unidade',
        'quantidade_atual',
        'quantidade_minima',
        'custo_unitario',
        'fornecedor',
        'ativo',
    ];

    protected function casts(): array
    {
        return [
            'quantidade_atual' => 'decimal:3',
            'quantidade_minima' => 'decimal:3',
            'custo_unitario' => 'decimal:4',
            'ativo' => 'boolean',
        ];
    }

    public function scopeAtivos(Builder $query): Builder
    {
        return $query->where('ativo', true);
    }

    public function scopeEstoqueBaixo(Builder $query): Builder
    {
        return $query->whereColumn('quantidade_atual', '<=', 'quantidade_minima');
    }

    public function temEstoqueBaixo(): bool
    {
        return $this->quantidade_atual <= $this->quantidade_minima;
    }
}
