<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Botão da página "link na bio" (/links), usada na bio do Instagram.
 */
class LinkBio extends Model
{
    protected $table = 'link_bios';

    protected $fillable = [
        'icone',
        'label',
        'url',
        'hint',
        'cliques',
        'ordem',
        'ativo',
    ];

    protected function casts(): array
    {
        return [
            'cliques' => 'integer',
            'ordem' => 'integer',
            'ativo' => 'boolean',
        ];
    }

    /**
     * Ícones disponíveis (o design usa códigos monoespaçados de até 3 letras).
     */
    public const ICONES = [
        'WA'  => 'WA · WhatsApp',
        'B2C' => 'B2C · Catálogo pessoal',
        'B2B' => 'B2B · Catálogo empresas',
        'PAR' => 'PAR · Parcerias',
        'IG'  => 'IG · Instagram',
        '@'   => '@ · E-mail',
        'URL' => 'URL · Link genérico',
        'PIX' => 'PIX · Pagamento',
    ];

    // ====== Scopes ======

    public function scopeAtivos(Builder $query): Builder
    {
        return $query->where('ativo', true);
    }

    public function scopeOrdenados(Builder $query): Builder
    {
        return $query->orderBy('ordem')->orderBy('id');
    }

    // ====== Helpers ======

    /**
     * Links externos abrem em nova aba; caminhos internos ("/catalogo") não.
     */
    public function isExterno(): bool
    {
        return (bool) preg_match('#^(https?:|mailto:|tel:)#i', $this->url);
    }
}
