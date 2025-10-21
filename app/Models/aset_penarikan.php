<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class aset_penarikan extends Model
{
    use HasFactory;
    protected $table = 'aset_penarikan';
    public $timestamps = true;
    use SoftDeletes;
}
