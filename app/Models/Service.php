<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Service extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
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
