<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;

class Certificate extends Model
{
    use SoftDeletes;
    use hasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'organization',
        'issue_date',
        'credential_url',
        'image',
        'sort_order',
        'status',
    ];
    
    protected $casts = [
        'status' => 'boolean',
        'issue_date' => 'date',
    ];
    public function user()
{
    return $this->belongsTo(User::class);
}
}
