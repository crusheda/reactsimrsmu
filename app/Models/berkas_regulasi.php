<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class berkas_regulasi extends Model
{
    use HasFactory;
    protected $table = 'berkas_regulasi';
    public $timestamps = true;
    use SoftDeletes;
}
