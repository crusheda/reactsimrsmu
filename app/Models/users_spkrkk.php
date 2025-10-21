<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class users_spkrkk extends Model
{
    use HasFactory;
    protected $table = 'users_spkrkk';
    public $timestamps = true;
    use SoftDeletes;
}
