<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ScreenshotController;
use Illuminate\Support\Facades\Route;

// Root — auth users go to strat-chat, guests go to login
Route::get('/', function () {
    return redirect()->route(auth()->check() ? 'strat-chat' : 'login');
})->name('home');

// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store']);

    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);

    Route::get('/forgot-password', [ForgotPasswordController::class, 'create'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'store'])->name('password.email');

    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'create'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'store'])->name('password.update');
});

// Auth routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

    Route::get('/onboarding', \App\Livewire\Onboarding::class)->name('onboarding');
    Route::get('/strat-chat', \App\Livewire\StratChat::class)->name('strat-chat');
    Route::get('/dashboard', fn () => redirect()->route('strat-chat'))->name('dashboard');
    Route::get('/settings', \App\Livewire\SettingsPage::class)->name('settings');

    // Content pages
    Route::get('/mindset', \App\Livewire\TheMindset::class)->name('mindset');
    Route::get('/playbook', \App\Livewire\ThePlaybook::class)->name('playbook');
    Route::get('/quick-ref', \App\Livewire\QuickReference::class)->name('quick-ref');

    // Screenshots
    Route::get('/screenshots/{filename}', [ScreenshotController::class, 'show'])->name('screenshots.show');

    // Contact Thread
    Route::get('/contacts/{contact}', \App\Livewire\ContactThread::class)->name('contacts.show');

    // Contacts
    Route::post('/contacts', [ContactController::class, 'store'])->name('contacts.store');
    Route::put('/contacts/{contact}', [ContactController::class, 'update'])->name('contacts.update');
    Route::patch('/contacts/{contact}/archive', [ContactController::class, 'archive'])->name('contacts.archive');
    Route::patch('/contacts/{contact}/restore', [ContactController::class, 'restore'])->name('contacts.restore');
    Route::delete('/contacts/{contact}', [ContactController::class, 'destroy'])->name('contacts.destroy');
});
