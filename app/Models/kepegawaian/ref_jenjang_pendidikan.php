<?php

namespace App\Models\kepegawaian;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ref_jenjang_pendidikan extends Model
{
    protected $table = 'referensi_jenjang_pendidikan';
    public $timestamps = true;
    use SoftDeletes;
    use HasFactory;
}
