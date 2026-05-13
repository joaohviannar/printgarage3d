<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Configuracao extends Model
{
    protected $table = 'configuracoes';

    public $timestamps = false;

    protected $fillable = [
        'chave',
        'valor',
    ];

    protected static function booted(): void
    {
        static::saved(function () {
            // Limpa cache do ConfiguracaoService quando algo muda
            \App\Services\ConfiguracaoService::flush();
        });
    }
}
