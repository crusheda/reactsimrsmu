<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class aset_pengembalian extends Model
{
    use HasFactory;
    protected $table = 'aset_pengembalian';
    public $timestamps = true;
    use SoftDeletes;
}
