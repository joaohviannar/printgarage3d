<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CatalogoController extends Controller
{
    public function index(Request $request): View
    {
        $tipo = $request->query('tipo', 'B2C');
        $tipo = in_array($tipo, ['B2C', 'B2B']) ? $tipo : 'B2C';

        $categoriaId = $request->query('categoria');

        $categorias = Categoria::ativas()
            ->where('tipo', $tipo)
            ->orderBy('ordem')
            ->get();

        $produtos = Produto::visiveisNoSite()
            ->doTipo($tipo)
            ->when($categoriaId, fn($q) => $q->where('categoria_id', $categoriaId))
            ->with('categoria')
            ->orderByDesc('destaque')
            ->orderBy('nome')
            ->paginate(12);

        return view('site.catalogo', compact('tipo', 'categorias', 'produtos', 'categoriaId'));
    }

    public function show(string $slug): View
    {
        $produto = Produto::visiveisNoSite()
            ->where('slug', $slug)
            ->with(['categoria', 'imagens'])
            ->firstOrFail();

        $relacionados = Produto::visiveisNoSite()
            ->where('categoria_id', $produto->categoria_id)
            ->where('id', '!=', $produto->id)
            ->limit(4)
            ->get();

        return view('site.produto', compact('produto', 'relacionados'));
    }
}
