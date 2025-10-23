<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class LoginController extends Controller
{
    function index()
    {
        if (Auth::check()) {
            // return redirect()->route('v4.dashboard');
            return "kamu sudah login (LoginController@index)";
        } else {
            // return view('pages.auth.login');
            return "kamu belum login (LoginController@index)";
        }
    }
}
