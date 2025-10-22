<?php

namespace App\Http\Controllers\React\SDI;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PegawaiController extends Controller
{
    function index()
    {
        return Inertia::render('SDI/Pegawai');
    }
}
