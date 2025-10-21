<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class LoginController extends Controller
{
    function index()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        } else {
            return view('pages.auth.login');
        }
    }
}
