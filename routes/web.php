<?php

use App\Http\Controllers\Site\CatalogoController;
use App\Http\Controllers\Site\HomeController;
use App\Http\Controllers\Site\LinkBioController;
use App\Http\Controllers\Site\ParceriaController;
use App\Http\Controllers\Site\SitemapController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rotas Públicas (Site / Vitrine)
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('site.home');

Route::get('/catalogo', [CatalogoController::class, 'index'])->name('site.catalogo');
Route::get('/produto/{slug}', [CatalogoController::class, 'show'])->name('site.produto');
Route::get('/parcerias', [ParceriaController::class, 'index'])->name('site.parcerias');

// Landing B2B exclusiva (acessada apenas por link direto — noindex)
Route::view('/exclusivo/barbearia', 'site.barbearia')->name('site.b2b.barbearia');

// Landing do programa de parceiros para pet shops (pública e indexável)
Route::view('/parceria/petshop', 'site.petshop')->name('site.b2b.petshop');

// Link na bio (Instagram)
Route::get('/links', [LinkBioController::class, 'index'])->name('site.links');

// Contador de cliques: mantém CSRF (o token vai no beacon) e limita a
// frequência para ninguém inflar o contador de fora.
Route::post('/links/{link}/clique', [LinkBioController::class, 'clique'])
    ->middleware('throttle:30,1')
    ->name('site.links.clique');

// SEO
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('site.sitemap');
