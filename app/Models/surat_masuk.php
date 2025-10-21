<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class surat_masuk extends Model
{
    use HasFactory;
    protected $table = 'berkas_surat_masuk';
    public $timestamps = true;
    use SoftDeletes;
}
