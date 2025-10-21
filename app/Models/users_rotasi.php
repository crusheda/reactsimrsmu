<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class users_rotasi extends Model
{
    use HasFactory;
    protected $table = 'users_rotasi';
    public $timestamps = true;
    use SoftDeletes;
}
