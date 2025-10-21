<?php

namespace App\Models\kepegawaian;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\kepegawaian\device;

class fcm_tokens extends Model
{
    use HasFactory;
    protected $table = 'fcm_tokens';
    public $timestamps = true;
    use SoftDeletes;

    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // Relasi ke admin
    public function admin()
    {
        return $this->belongsTo(User::class, 'accepted_user', 'id');
    }

    // Relasi 1 row ke android_model, ambil id terkecil per model
    public function androidModel()
    {
        return $this->hasOne(device::class, 'model', 'model')
                    ->orderBy('id', 'asc'); // ambil 1 row pertama per model
    }
}
