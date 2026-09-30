<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use Illuminate\View\View;

class AboutController extends Controller
{
    public function index(): View
    {
        return view('about', [
            'partners' => Partner::active()->ordered()->get(),
        ]);
    }
}
