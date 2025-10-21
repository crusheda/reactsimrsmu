<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class referensi extends Model
{
    use HasFactory;
    protected $table = 'referensi';
    public $timestamps = true;
    use SoftDeletes;
}
