<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Illuminate\Database\Eloquent\Model;

class roles extends Model
{
    use HasFactory;
    use Loggable;
    protected $table = 'roles';
    public $timestamps = true;
}
