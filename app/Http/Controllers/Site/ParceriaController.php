<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Parceria;
use Illuminate\View\View;

class ParceriaController extends Controller
{
    public function index(): View
    {
        $parcerias = Parceria::ativas()->get();

        return view('site.parcerias', compact('parcerias'));
    }
}
