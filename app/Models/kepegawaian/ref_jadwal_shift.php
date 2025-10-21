<?php

namespace App\Models\kepegawaian;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ref_jadwal_shift extends Model
{
    protected $table = 'referensi_jadwal_shift';
    public $timestamps = true;
    use SoftDeletes;
    use HasFactory;
}
