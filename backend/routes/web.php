<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\CampaignController;
use App\Http\Controllers\Admin\SubscriberController;
use App\Http\Controllers\Admin\LeadController;
use App\Http\Controllers\Admin\TicketController as AdminTicketController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboard;
use App\Http\Controllers\Customer\TicketController as CustomerTicketController;
use App\Http\Controllers\LeadCaptureController;

Route::get('/', fn() => view('welcome'));
Route::post('/contact', [LeadCaptureController::class, 'store'])->name('contact.submit');

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
    Route::get('/register', [RegisterController::class, 'showForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');
});
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware(['auth'])->prefix('dashboard')->name('customer.')->group(function () {
    Route::get('/', [CustomerDashboard::class, 'index'])->name('dashboard');
    Route::get('/projects', [CustomerDashboard::class, 'projects'])->name('projects');
    Route::get('/invoices', [CustomerDashboard::class, 'invoices'])->name('invoices');
    Route::resource('tickets', CustomerTicketController::class)->only(['index','create','store','show']);
    Route::post('tickets/{ticket}/reply', [CustomerTicketController::class, 'reply'])->name('tickets.reply');
});

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', UserController::class)->except(['create','store']);
    Route::resource('pages', PageController::class);
    Route::resource('posts', PostController::class);
    Route::resource('campaigns', CampaignController::class);
    Route::post('campaigns/ai-generate', [CampaignController::class, 'generateAi'])->name('campaigns.ai-generate');
    Route::get('subscribers', [SubscriberController::class, 'index'])->name('subscribers.index');
    Route::post('subscribers', [SubscriberController::class, 'store'])->name('subscribers.store');
    Route::delete('subscribers/{subscriber}', [SubscriberController::class, 'destroy'])->name('subscribers.destroy');
    Route::post('subscriber-lists', [SubscriberController::class, 'storeList'])->name('subscriber-lists.store');
    Route::resource('leads', LeadController::class)->except(['create','store']);
    Route::resource('tickets', AdminTicketController::class)->only(['index','show','update']);
    Route::post('tickets/{ticket}/reply', [AdminTicketController::class, 'reply'])->name('tickets.reply');
    Route::get('media', [MediaController::class, 'index'])->name('media.index');
    Route::post('media', [MediaController::class, 'store'])->name('media.store');
    Route::delete('media/{medium}', [MediaController::class, 'destroy'])->name('media.destroy');
    Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::put('settings', [SettingsController::class, 'update'])->name('settings.update');
});
