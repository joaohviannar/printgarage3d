<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cliente extends Model
{
    protected $table = 'clientes';

    protected $fillable = [
        'nome',
        'tipo',
        'documento',
        'telefone',
        'email',
        'instagram',
        'observacoes',
    ];

    public function vendas(): HasMany
    {
        return $this->hasMany(Venda::class);
    }
}
