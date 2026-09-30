<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BlogCategoryController;
use App\Http\Controllers\Admin\BlogPostController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\TeamMemberController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('login', [AuthController::class, 'create'])->name('login');
        Route::post('login', [AuthController::class, 'store'])->name('login.store');
    });

    Route::post('logout', [AuthController::class, 'destroy'])
        ->middleware('auth')
        ->name('logout');

    Route::middleware('admin')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('products', ProductController::class)->except('show');
        Route::resource('partners', PartnerController::class)->except('show');
        Route::resource('team', TeamMemberController::class)->except('show');

        Route::patch('products/{product}/publish', [ProductController::class, 'publish'])->name('products.publish');
        Route::patch('partners/{partner}/publish', [PartnerController::class, 'publish'])->name('partners.publish');
        Route::patch('team/{team}/publish', [TeamMemberController::class, 'publish'])->name('team.publish');

        Route::resource('posts', BlogPostController::class)->except('show');
        Route::patch('posts/{post}/publish', [BlogPostController::class, 'publish'])->name('posts.publish');
        Route::resource('post-categories', BlogCategoryController::class)->except('show');

        Route::get('messages', [ContactMessageController::class, 'index'])->name('messages.index');
        Route::get('messages/{message}', [ContactMessageController::class, 'show'])->name('messages.show');
        Route::patch('messages/{message}', [ContactMessageController::class, 'update'])->name('messages.update');
        Route::delete('messages/{message}', [ContactMessageController::class, 'destroy'])->name('messages.destroy');

        Route::middleware('administrator')->group(function () {
            Route::resource('users', UserController::class)->except('show');
            Route::get('settings', [SettingController::class, 'edit'])->name('settings.edit');
            Route::put('settings', [SettingController::class, 'update'])->name('settings.update');
        });
    });
});
