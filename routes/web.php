<?php

use App\Http\Controllers\Site\CatalogoController;
use App\Http\Controllers\Site\HomeController;
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

// SEO
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('site.sitemap');
