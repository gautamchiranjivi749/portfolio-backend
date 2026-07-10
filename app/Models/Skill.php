<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Skill extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'percentage',
        'icon',
        'sort_order',
        'status',
    ];
     protected $casts = [
        'status' => 'boolean',
    ];
}
