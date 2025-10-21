<?php

namespace App\Models\kepegawaian;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class surtug extends Model
{
    use HasFactory;
    protected $table = 'kepegawaian_surtug';
    public $timestamps = true;
    use SoftDeletes;
}
