<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Illuminate\Database\Eloquent\Model;

class role_has_permissions extends Model
{
    use HasFactory;
    use Loggable;
    protected $table = 'role_has_permissions';
    public $timestamps = false;
}
