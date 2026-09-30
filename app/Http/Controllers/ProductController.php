<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        return view('products.index', [
            'products' => Product::published()->ordered()->get(),
        ]);
    }

    public function riskAssessment(): View
    {
        return view('products.risk-assessment', [
            'product' => Product::published()->where('slug', 'risk-assessment')->first(),
        ]);
    }

    public function imageAnalysis(): View
    {
        return view('products.image-analysis', [
            'product' => Product::published()->where('slug', 'ai-image-analysis')->first(),
        ]);
    }
}
