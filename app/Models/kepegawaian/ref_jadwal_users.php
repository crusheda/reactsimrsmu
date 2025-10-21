<?php

namespace App\Models\kepegawaian;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ref_jadwal_users extends Model
{
    protected $table = 'referensi_jadwal_users';
    public $timestamps = true;
    use SoftDeletes;
    use HasFactory;
}
