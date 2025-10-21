<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class perbaikan_ipsrs extends Model
{
    use HasFactory;
    protected $table = 'perbaikan_ipsrs';
    public $timestamps = true;
    use SoftDeletes;
}
