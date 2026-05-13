<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MovimentacaoEstoque extends Model
{
    protected $table = 'movimentacoes_estoque';

    public const UPDATED_AT = null;

    protected $fillable = [
        'produto_id',
        'tipo',
        'quantidade',
        'estoque_anterior',
        'estoque_posterior',
        'origem',
        'referencia_id',
        'user_id',
        'observacao',
    ];

    protected function casts(): array
    {
        return [
            'quantidade' => 'integer',
            'estoque_anterior' => 'integer',
            'estoque_posterior' => 'integer',
            'created_at' => 'datetime',
        ];
    }

    public function produto(): BelongsTo
    {
        return $this->belongsTo(Produto::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
