<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class datalogs extends Model
{
    use HasFactory;
    protected $table = 'datalogs';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'ip',
        'event',
        'extra',
        'before',
        'after',
        'role_target'
    ];

    public static function record($user_id = null, $event, $extra, $before, $after, $role_target)
    {
        return static::create([
            'user_id' => is_null($user_id) ? null : $user_id, // User saat ini
            'ip' => request()->ip(),
            'event' => $event, // Pesan pendukung
            'extra' => $extra,
            'before' => $before,
            'after' => $after,
            'role_target' => $role_target // Log diperuntukkan untuk siapa saja
        ]);
    }
}
