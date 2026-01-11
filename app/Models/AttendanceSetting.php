<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'check_in_start',
        'check_in_end',
        'check_out_start',
        'check_out_end',
        'latitude',
        'longitude',
        'radius_meters',
        'working_days',
        'timezone',
        'is_active',
    ];

    protected $casts = [
        'working_days' => 'array',
        'is_active' => 'boolean',
    ];
}
