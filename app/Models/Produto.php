<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Produto extends Model
{
    protected $table = 'produtos';

    protected $fillable = [
        'categoria_id',
        'nome',
        'slug',
        'descricao',
        'descricao_curta',
        'sku',
        'preco_venda',
        'preco_custo',
        'estoque_atual',
        'estoque_minimo',
        'imagem_principal',
        'destaque',
        'visivel_site',
        'ativo',
    ];

    protected function casts(): array
    {
        return [
            'preco_venda' => 'decimal:2',
            'preco_custo' => 'decimal:2',
            'estoque_atual' => 'integer',
            'estoque_minimo' => 'integer',
            'destaque' => 'boolean',
            'visivel_site' => 'boolean',
            'ativo' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (Produto $produto) {
            if (empty($produto->slug) && !empty($produto->nome)) {
                $produto->slug = Str::slug($produto->nome);
            }
        });
    }

    // ====== Relacionamentos ======

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class);
    }

    public function imagens(): HasMany
    {
        return $this->hasMany(ProdutoImagem::class)->orderBy('ordem');
    }

    public function itensVenda(): HasMany
    {
        return $this->hasMany(ItemVenda::class);
    }

    public function movimentacoes(): HasMany
    {
        return $this->hasMany(MovimentacaoEstoque::class);
    }

    // ====== Scopes ======

    public function scopeAtivos(Builder $query): Builder
    {
        return $query->where('ativo', true);
    }

    public function scopeVisiveisNoSite(Builder $query): Builder
    {
        return $query->where('visivel_site', true)->where('ativo', true);
    }

    public function scopeDestaque(Builder $query): Builder
    {
        return $query->where('destaque', true);
    }

    public function scopeEstoqueBaixo(Builder $query): Builder
    {
        return $query->whereColumn('estoque_atual', '<=', 'estoque_minimo');
    }

    public function scopeDoTipo(Builder $query, string $tipo): Builder
    {
        return $query->whereHas('categoria', fn($q) => $q->where('tipo', $tipo));
    }

    // ====== Helpers ======

    public function temEstoque(int $quantidade = 1): bool
    {
        return $this->estoque_atual >= $quantidade;
    }

    public function temEstoqueBaixo(): bool
    {
        return $this->estoque_atual <= $this->estoque_minimo;
    }
}
