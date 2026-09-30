<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\SiteSetting;
use App\Models\TeamMember;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        return view('home', [
            'products' => Product::published()->ordered()->get(),
            'team' => TeamMember::active()->ordered()->get(),
            'settings' => SiteSetting::map(),
        ]);
    }
}
