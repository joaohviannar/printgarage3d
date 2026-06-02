<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Produto;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $destaques = Produto::visiveisNoSite()
            ->destaque()
            ->with('categoria')
            ->orderByDesc('created_at')
            ->limit(12)
            ->get();

        return view('site.home', compact('destaques'));
    }
}
