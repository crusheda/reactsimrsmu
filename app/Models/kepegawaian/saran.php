<?php

namespace App\Models\kepegawaian;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class saran extends Model
{
    use HasFactory;
    protected $table = 'kepegawaian_saran';
    public $timestamps = true;
    use SoftDeletes;
}
