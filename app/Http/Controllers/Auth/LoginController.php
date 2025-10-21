<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    public function showLoginForm()
    {
        // return view('pages.auth.login');
        return redirect()->route('auth.login');
        // return redirect()->route('login');
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
            'captcha' => 'required|captcha',
        ]);
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'name';
    }

    protected function attemptLogin(Request $request)
    {
        $credentials = $this->credentials($request);

        // ambil user dari database berdasarkan field username()
        $user = User::where($this->username(), $credentials[$this->username()])->first();

        if ($user && $user->status == 1) {
            // kalau status = 1 → blokir login
            return false;
        }

        // kalau status NULL atau bukan 1 → lanjut login normal
        return $this->guard()->attempt(
            $credentials,
            $request->filled('remember')
        );
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        $user = User::where($this->username(), $request->{$this->username()})->first();

        if (!$user) {
            // username salah
            throw ValidationException::withMessages([
                $this->username() => ['Username tidak ditemukan. Pastikan Username telah didaftarkan sebelumnya.'],
            ]);
        }

        if ($user && $user->status == 1) {
            throw ValidationException::withMessages([
                $this->username() => ['Akun anda telah dinonaktifkan oleh Sistem, silakan hubungi Administrator.'],
            ]);
        }

        // username benar tapi password salah
        throw ValidationException::withMessages([
            'password' => ['Password yang anda masukkan salah. Silakan coba lagi.'],
        ]);
    }
}
