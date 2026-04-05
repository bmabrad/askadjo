<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ScreenshotController;
use Illuminate\Support\Facades\Route;

// Home page — guests see sales page, auth users redirect to coach
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('coach');
    }

    return view('home');
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

// Temporary debug route — REMOVE after Cloud config is verified
Route::middleware('auth')->get('/debug-env', function () {
    return response()->json([
        'AWS_ACCESS_KEY_ID' => env('AWS_ACCESS_KEY_ID') ? '✓ set (' . substr(env('AWS_ACCESS_KEY_ID'), 0, 6) . '...)' : '✗ missing',
        'AWS_SECRET_ACCESS_KEY' => env('AWS_SECRET_ACCESS_KEY') ? '✓ set' : '✗ missing',
        'AWS_DEFAULT_REGION' => env('AWS_DEFAULT_REGION') ?: '✗ missing',
        'AWS_BUCKET' => env('AWS_BUCKET') ?: '✗ missing',
        'FILESYSTEM_DISK' => env('FILESYSTEM_DISK') ?: '✗ missing',
        'SCREENSHOTS_DISK' => env('SCREENSHOTS_DISK') ?: '✗ missing',
        'ANTHROPIC_API_KEY' => env('ANTHROPIC_API_KEY') ? '✓ set (' . substr(env('ANTHROPIC_API_KEY'), 0, 10) . '...)' : '✗ missing',
        'ANTHROPIC_MODEL' => env('ANTHROPIC_MODEL') ?: '✗ missing',
        'all_aws_keys' => collect($_ENV)->filter(fn ($v, $k) => str_starts_with($k, 'AWS') || str_starts_with($k, 'S3') || str_starts_with($k, 'FILESYSTEM'))->keys()->toArray(),
    ]);
});

// Auth routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

    Route::get('/welcome', fn () => view('auth.welcome'))->name('welcome');

    Route::get('/coach', \App\Livewire\CoachWindow::class)->name('coach');
    Route::get('/dashboard', fn () => redirect()->route('coach'))->name('dashboard');
    Route::get('/settings', \App\Livewire\SettingsPage::class)->name('settings');

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
