<?php

namespace App\Http\Controllers\React\Akun;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProfilController extends Controller
{
    function index()
    {
        return Inertia::render('Akun/Profil');
    }
}
