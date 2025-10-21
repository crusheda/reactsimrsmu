<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class accident_report extends Model
{
    use HasFactory;
    protected $table = 'mfk_accident_report';
    public $timestamps = true;
    use SoftDeletes;
}
