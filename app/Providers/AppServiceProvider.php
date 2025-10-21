<?php

namespace App\Providers;

use Inertia\Inertia;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\Models\users;
use App\Models\users_foto;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);
        Inertia::share([
            'auth.user' => function () {
                if (Auth::check()) {
                    $user = Auth::user();
                    $foto = users_foto::where('user_id', $user->id)->first();
                    return [
                        'id' => $user->id,
                        'nama' => $user->nama,
                        'email' => $user->email,
                        'foto' => $foto?->foto ?? null,
                    ];
                }
            },
        ]);
    }
}
