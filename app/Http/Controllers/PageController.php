<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class PageController extends Controller
{
    public function home(): View
    {
        return view('home');
    }

    public function about(): View
    {
        return view('a-propos', [
            'auteur' => 'Mouhib Laifi',
            'groupe' => 'MDW32',
        ]);
    }
}
