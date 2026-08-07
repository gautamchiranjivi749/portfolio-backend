<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;
class Contact extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id',
        'email',
        'subject',
        'message',
        'status',
    ];

     protected $casts = [
        'is_read' => 'boolean',
    ];
    public function user()
{
    return $this->belongsTo(User::class);
}
}
