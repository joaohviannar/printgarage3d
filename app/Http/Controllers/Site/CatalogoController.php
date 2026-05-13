<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CatalogoController extends Controller
{
    public function index(Request $request): View
    {
        $tipo = $request->query('tipo', 'B2C'); // B2C ou B2B
        $tipo = in_array($tipo, ['B2C', 'B2B']) ? $tipo : 'B2C';

        // Stub: depois substituir por queries reais quando tivermos Models Produto/Categoria
        $produtos = collect();

        return view('site.catalogo', compact('tipo', 'produtos'));
    }

    public function show(string $slug): View
    {
        // Stub: depois substituir por busca real
        abort_unless(false, 404);

        return view('site.produto');
    }
}
