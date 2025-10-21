<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Illuminate\Database\Eloquent\Model;

class model_has_roles extends Model
{
    use HasFactory;
    use Loggable;
    protected $table = 'model_has_roles';
    public $timestamps = false;
}
