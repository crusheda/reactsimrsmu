<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class skl extends Model
{
    use HasFactory;
    protected $table = 'pelayanan_skl';
    public $timestamps = true;
    use SoftDeletes;
}
