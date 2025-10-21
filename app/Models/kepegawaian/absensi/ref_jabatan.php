<?php

namespace App\Models\kepegawaian\absensi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ref_jabatan extends Model
{
    use HasFactory;
    protected $table = 'referensi_jadwal_users_jabatan';
    public $timestamps = true;
    use SoftDeletes;
}
