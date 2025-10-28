<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use App\Models\users_foto;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $user = $request->user();

        // Ambil foto user kalau login
        $foto = null;
        if ($user) {
            $dataFoto = users_foto::where('user_id', $user->id)
                ->whereNull('deleted_at')
                ->first();

            if ($dataFoto) {
                $foto = asset(str_replace('public/', '/storage/', $dataFoto->filename));
            }
        }

        return [
            ...parent::share($request),

            'auth' => [
                // tetap gunakan user asli dari $request->user()
                'user' => $user ? array_merge($user->toArray(), [
                    'foto' => $foto,
                ]) : null,
            ],
            'flash' => [
                'message' => fn () => $request->session()->get('message'),
            ],
        ];

        // return [
        //     ...parent::share($request),
        //     'auth' => [
        //         'user' => $request->user(),
        //     ],
        // ];
    }
}
