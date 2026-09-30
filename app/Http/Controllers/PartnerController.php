<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use Illuminate\View\View;

class PartnerController extends Controller
{
    public function index(): View
    {
        return view('partners.index', [
            'partners' => Partner::active()->ordered()->get(),
        ]);
    }
}
