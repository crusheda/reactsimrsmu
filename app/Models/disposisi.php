<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class disposisi extends Model
{
    use HasFactory;
    protected $table = 'disposisi';
    public $timestamps = true;
    use SoftDeletes;
}
