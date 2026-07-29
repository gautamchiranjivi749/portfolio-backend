<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
class SocialLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'platform',
        'url',
        'icon',
        'sort_order',
        'status',
    ];

     protected $casts = [
        'status' => 'boolean',
    ];
    public function user()
{
    return $this->belongsTo(User::class);
}
}
