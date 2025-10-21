<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class mutu_manrisk extends Model
{
    use HasFactory;
    protected $table = 'mutu_manrisk';
    public $timestamps = true;
    use SoftDeletes;
}
