<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Venda extends Model
{
    protected $table = 'vendas';

    protected $fillable = [
        'cliente_id',
        'user_id',
        'data_venda',
        'canal',
        'forma_pagamento',
        'subtotal',
        'desconto',
        'total',
        'status',
        'observacoes',
    ];

    protected function casts(): array
    {
        return [
            'data_venda' => 'date',
            'subtotal' => 'decimal:2',
            'desconto' => 'decimal:2',
            'total' => 'decimal:2',
        ];
    }

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function itens(): HasMany
    {
        return $this->hasMany(ItemVenda::class);
    }

    public function scopePagas(Builder $query): Builder
    {
        return $query->where('status', 'pago');
    }

    public function scopeCanceladas(Builder $query): Builder
    {
        return $query->where('status', 'cancelado');
    }

    /**
     * Recalcula subtotal e total com base nos itens.
     */
    public function recalcular(): void
    {
        $subtotal = $this->itens()->sum('subtotal');
        $this->update([
            'subtotal' => $subtotal,
            'total' => max(0, $subtotal - $this->desconto),
        ]);
    }
}
