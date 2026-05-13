<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Despesa extends Model
{
    protected $table = 'despesas';

    protected $fillable = [
        'categoria_despesa_id',
        'user_id',
        'descricao',
        'valor',
        'data_despesa',
        'forma_pagamento',
        'recorrente',
        'anexo',
        'observacoes',
    ];

    protected function casts(): array
    {
        return [
            'valor' => 'decimal:2',
            'data_despesa' => 'date',
            'recorrente' => 'boolean',
        ];
    }

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(CategoriaDespesa::class, 'categoria_despesa_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeNoMes(Builder $query, ?int $ano = null, ?int $mes = null): Builder
    {
        $ano ??= now()->year;
        $mes ??= now()->month;

        return $query->whereYear('data_despesa', $ano)->whereMonth('data_despesa', $mes);
    }
}
