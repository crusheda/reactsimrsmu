<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class perbaikan_ipsrs_catatan extends Model
{
    use HasFactory;
    protected $table = 'perbaikan_ipsrs_catatan';
    public $timestamps = true;
    use SoftDeletes;
}
