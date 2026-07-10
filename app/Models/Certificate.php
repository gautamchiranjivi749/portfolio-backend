<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Certificate extends Model
{
    use hasFactory;

    protected $fillable = [
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
}
