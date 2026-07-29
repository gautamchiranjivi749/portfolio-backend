<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class Education extends Model
{
    use HasFactory;

    protected $table = 'educations';

    protected $fillable = [
        'user_id',
        'institution_name',
        'degree',
        'field_of_study',
        'start_year',
        'end_year',
        'gpa',
        'description',
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