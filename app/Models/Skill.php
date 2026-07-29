<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class Skill extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'percentage',
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
