<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class pengadaan extends Model
{
    use HasFactory;
    protected $table = 'pengadaan';
    public $timestamps = true;
    use SoftDeletes;
}
