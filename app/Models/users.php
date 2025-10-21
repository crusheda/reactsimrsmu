<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Illuminate\Database\Eloquent\SoftDeletes;

class users extends Model
{
    use HasFactory;
    use Loggable;
    use SoftDeletes;
    protected $table = 'users';
    public $timestamps = true;
}
