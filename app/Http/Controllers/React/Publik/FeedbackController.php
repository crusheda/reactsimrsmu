<?php

namespace App\Http\Controllers\React\Publik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FeedbackController extends Controller
{
    function index()
    {
        return Inertia::render('Feedback');
    }
}
