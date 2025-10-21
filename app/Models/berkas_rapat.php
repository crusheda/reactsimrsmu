<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class berkas_rapat extends Model
{
    use HasFactory;
    protected $table = 'berkas_rapat';
    public $timestamps = true;
    use SoftDeletes;
}
