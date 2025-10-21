<?php

namespace App\Http\Controllers\Kalender;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KalenderController extends Controller
{
    function index()
    {
        return view('pages.kalender.index');
    }

    function dataKalender()
    {
        $events = [
            ['title' => 'Shift Pagi', 'start' => '2025-10-20'],
            ['title' => 'Shift Malam', 'start' => '2025-10-21', 'end' => '2025-10-22'],
            ['title' => 'Meeting Tim IT', 'start' => '2025-10-25T10:00:00']
        ];
        return response()->json($events, 200);
    }

    function tambahKalender(Request $request)
    {
        DB::table('events')->insert([
            'title' => $request->title,
            'start' => $request->start,
        ]);
        return response()->json(['success' => true]);
    }
}
