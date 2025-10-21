<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\datalogs;
use Auth;

class ViewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        View::composer('inc.nwheader', function ($view) {
            if (Auth::user()->getManyPermission(["admin_kepegawaian","admin_kepegawaian_kepala"]) == true) {
                $logs = datalogs::join('users', 'users.id', '=', 'datalogs.user_id')
                    ->select('users.nama', 'datalogs.*')
                    ->orderBy('datalogs.created_at', 'desc')
                    ->limit(15)
                    ->get();

                $countLogs = datalogs::count();
            } else {
                $logs = collect();
                $countLogs = 0;
            }

            $view->with([
                'logs' => $logs,
                'countLogs' => $countLogs
            ]);
        });
    }
}
