<?php

use App\Http\Controllers\Site\CatalogoController;
use App\Http\Controllers\Site\HomeController;
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

// SEO
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('site.sitemap');
