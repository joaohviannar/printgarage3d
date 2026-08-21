<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Produto;
use Illuminate\Http\Response;

/**
 * Gera o sitemap.xml dinamico com todas as URLs publicas do site,
 * para o Google indexar paginas e produtos.
 */
class SitemapController extends Controller
{
    public function index(): Response
    {
        $urls = [];

        // Home
        $urls[] = [
            'loc' => route('site.home'),
            'changefreq' => 'weekly',
            'priority' => '1.0',
        ];

        // Catalogos
        $urls[] = [
            'loc' => route('site.catalogo', ['tipo' => 'B2C']),
            'changefreq' => 'weekly',
            'priority' => '0.9',
        ];
        $urls[] = [
            'loc' => route('site.catalogo', ['tipo' => 'B2B']),
            'changefreq' => 'weekly',
            'priority' => '0.9',
        ];

        // Parcerias
        $urls[] = [
            'loc' => route('site.parcerias'),
            'changefreq' => 'monthly',
            'priority' => '0.6',
        ];

        // Landing do programa de parceiros para pet shops
        $urls[] = [
            'loc' => route('site.b2b.petshop'),
            'changefreq' => 'monthly',
            'priority' => '0.8',
        ];

        // Produtos visiveis no site
        $produtos = Produto::visiveisNoSite()
            ->select(['slug', 'updated_at'])
            ->get();

        foreach ($produtos as $produto) {
            $urls[] = [
                'loc' => route('site.produto', $produto->slug),
                'lastmod' => $produto->updated_at?->toAtomString(),
                'changefreq' => 'monthly',
                'priority' => '0.7',
            ];
        }

        $xml = view('site.sitemap', compact('urls'))->render();

        return response($xml, 200)
            ->header('Content-Type', 'application/xml');
    }
}
