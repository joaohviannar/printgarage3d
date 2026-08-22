<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\LinkBio;
use Illuminate\Http\Response;
use Illuminate\View\View;

/**
 * Página "link na bio" (/links) usada na bio do Instagram, e o contador
 * de cliques de cada botão.
 */
class LinkBioController extends Controller
{
    public function index(): View
    {
        $links = LinkBio::ativos()->ordenados()->get();

        return view('site.links', compact('links'));
    }

    /**
     * Registra um clique. Chamado via navigator.sendBeacon antes de navegar:
     * o usuário não espera a resposta, então a página não fica mais lenta.
     */
    public function clique(LinkBio $link): Response
    {
        $link->increment('cliques');

        return response()->noContent();
    }
}
