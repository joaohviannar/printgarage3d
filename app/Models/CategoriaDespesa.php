<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CategoriaDespesa extends Model
{
    protected $table = 'categorias_despesa';

    public $timestamps = false;

    protected $fillable = [
        'nome',
        'cor',
        'ativo',
    ];

    protected function casts(): array
    {
        return [
            'ativo' => 'boolean',
        ];
    }

    public function despesas(): HasMany
    {
        return $this->hasMany(Despesa::class);
    }

    public function scopeAtivas($query)
    {
        return $query->where('ativo', true);
    }
}
