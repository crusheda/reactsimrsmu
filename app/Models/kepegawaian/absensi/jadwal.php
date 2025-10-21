<?php

namespace App\Models\kepegawaian\absensi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class jadwal extends Model
{
    use HasFactory;
    protected $table = 'kepegawaian_jadwal';
    public $timestamps = true;
    use SoftDeletes;
}
