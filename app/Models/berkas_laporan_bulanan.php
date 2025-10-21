<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class berkas_laporan_bulanan extends Model
{
    use HasFactory;
    protected $table = 'berkas_laporan_bulanan';
    public $timestamps = true;
    use SoftDeletes;
}
