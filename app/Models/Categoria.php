<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Categoria extends Model
{
    protected $table = 'categorias';

    protected $fillable = [
        'nome',
        'slug',
        'tipo',
        'descricao',
        'ordem',
        'ativo',
    ];

    protected function casts(): array
    {
        return [
            'ativo' => 'boolean',
            'ordem' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (Categoria $categoria) {
            if (empty($categoria->slug) && !empty($categoria->nome)) {
                $categoria->slug = Str::slug($categoria->nome);
            }
        });
    }

    public function produtos(): HasMany
    {
        return $this->hasMany(Produto::class);
    }

    public function scopeAtivas($query)
    {
        return $query->where('ativo', true);
    }

    public function scopeB2C($query)
    {
        return $query->where('tipo', 'B2C');
    }

    public function scopeB2B($query)
    {
        return $query->where('tipo', 'B2B');
    }
}
