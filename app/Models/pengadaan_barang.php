<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class pengadaan_barang extends Model
{
    use HasFactory;
    protected $table = 'pengadaan_barang';
    public $timestamps = true;
    use SoftDeletes;
}
