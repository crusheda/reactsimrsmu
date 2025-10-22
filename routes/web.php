<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// DAFTAR CONTROLLER REACT
use App\Http\Controllers\Dashboard\DefaultController;
use App\Http\Controllers\React\Publik\DashboardController;
use App\Http\Controllers\React\Publik\FeedbackController;
use App\Http\Controllers\React\Akun\ProfilController;
use App\Http\Controllers\React\SDI\PegawaiController;
// use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Services\WhatsappService;

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

Route::get('/', function () { return redirect()->route('dashboard'); });

Route::middleware(['auth'])->group(function () {

    // AKUN
    Route::get('/profil', [ProfilController::class, 'index'])->name('profil.index');

    // PUBLIK
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/feedback', [FeedbackController::class, 'index'])->name('feedback');

    // SDI
    Route::get('/sdi/pegawai', [PegawaiController::class, 'index'])->name('sdi.pegawai.index');

    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// FALLBACK ROUTE
Route::fallback(function () {
    return response()->view('pages.page404', [], 404);
});

require __DIR__.'/auth.php';
