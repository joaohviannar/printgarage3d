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
     * Ícones disponíveis. A chave é o identificador guardado no banco; o
     * desenho de cada um vive em resources/views/site/partials/link-icone.blade.php.
     *
     * WA, IG, TIKTOK e PIX são renderizados com a cor da própria marca;
     * os demais usam o vermelho da Print Garage 3D.
     */
    public const ICONES = [
        'WA'     => 'WhatsApp',
        'IG'     => 'Instagram',
        'TIKTOK' => 'TikTok',
        'B2C'    => 'Catálogo para pessoas (caixa)',
        'B2B'    => 'Catálogo para empresas (prédio)',
        'BARBER' => 'Barbearias (tesoura)',
        'PET'    => 'Pet shops (patinha)',
        'PAR'    => 'Parcerias (aperto de mãos)',
        '@'      => 'E-mail (envelope)',
        'PIX'    => 'PIX',
        'URL'    => 'Link genérico (corrente)',
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
