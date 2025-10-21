<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class antigen extends Model
{
    use HasFactory;
    protected $table = 'pelayanan_antigen';
    public $timestamps = true;
    use SoftDeletes;
}
