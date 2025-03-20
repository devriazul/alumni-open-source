<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'photo',
        'blood_group',
        'session',
        'department',
        'gender',
        'present_address',
        'permanent_address',
        'employment_status',
        'company_name',
        'position',
        'additional_info'
    ];

    protected $casts = [
        'additional_info' => 'array'
    ];
}