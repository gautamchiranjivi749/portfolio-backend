<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SocialLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'platform',
        'url',
        'icon',
        'sort_order',
        'status',
    ];

     protected $casts = [
        'status' => 'boolean',
    ];
}
