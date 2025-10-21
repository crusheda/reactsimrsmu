<?php

namespace App\Models\kepegawaian\rekrutmen;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class pengumuman extends Model
{
    use HasFactory;
    protected $table = 'rekrutmen_pengumuman';
    public $timestamps = true;
    use SoftDeletes;
}
