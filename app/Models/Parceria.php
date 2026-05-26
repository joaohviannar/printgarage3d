<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Parceria extends Model
{
    protected $table = 'parcerias';

    protected $fillable = [
        'nome',
        'logo',
        'contato',
        'descricao_curta',
        'descricao_completa',
        'ordem',
        'ativo',
    ];

    protected function casts(): array
    {
        return [
            'ordem' => 'integer',
            'ativo' => 'boolean',
        ];
    }

    /**
     * Apenas parcerias ativas, ordenadas pela ordem definida no admin.
     */
    public function scopeAtivas(Builder $query): Builder
    {
        return $query->where('ativo', true)->orderBy('ordem')->orderBy('nome');
    }
}
