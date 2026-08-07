<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Users;
use Illuminate\Database\Eloquent\SoftDeletes;
class About extends Model
{
    use SoftDeletes;
    use HAsFactory;

    protected $fillable = [
        'user_id',
        'name', 
        'profession',
        'description',
        'profile_image',
        'resume',
    ];
     public function user()
    {
        return $this->belongsTo(User::class);
    }
}
