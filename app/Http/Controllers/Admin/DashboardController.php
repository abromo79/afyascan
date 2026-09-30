<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\ContactMessage;
use App\Models\Partner;
use App\Models\Product;
use App\Models\TeamMember;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'totalProducts' => Product::count(),
            'totalPartners' => Partner::count(),
            'totalTeamMembers' => TeamMember::count(),
            'publishedPosts' => BlogPost::published()->count(),
            'unreadMessages' => ContactMessage::active()->unread()->count(),
            'recentPosts' => BlogPost::with('category')->latest('published_at')->latest()->limit(5)->get(),
            'recentMessages' => ContactMessage::active()->latest()->limit(5)->get(),
        ]);
    }
}
