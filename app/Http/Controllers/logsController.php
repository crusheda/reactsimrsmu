<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\datalogs;
use App\Models\users;
use Carbon\Carbon;
use Auth;

class logsController extends Controller
{
    function index()
    {
        $user  = users::where('nik','!=',null)->where('nama','!=',null)->orderBy('nama', 'asc')->get();

        $logs = datalogs::join('users', 'users.id', '=', 'datalogs.user_id')
            ->select('users.nama', 'datalogs.*')
            ->orderBy('datalogs.created_at', 'desc')
            ->get();

        $countLogs = datalogs::count();

        $data = [
            'user' => $user,
            'logs' => $logs,
            'countLogs' => $countLogs,
        ];

        return view('pages.logs.index')->with('list', $data);
    }
}
