<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class users_doc extends Model
{
    use HasFactory;
    protected $table = 'users_doc';
    public $timestamps = true;
    use SoftDeletes;
}
