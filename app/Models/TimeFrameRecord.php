<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeFrameRecord extends Model
{
    use HasFactory;

    protected $primaryKey = 'timeFrameID';

    protected $fillable = [
        'description',
        'semester',
        'academic_year',
        'startDate',
        'endDate',
        'status',
        'is_active',
    ];
}
