<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentRecord extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'time',
        'date',
        'status',
        'meeting_type',
        'meeting_link',
        'rejection_reason',
        'lecturerID',
        'studentID',
    ];

    public function lecturer()
    {
        return $this->belongsTo(LecturerRecord::class, 'lecturerID', 'lecturerID');
    }

    // Relationship with StudentRecord
    public function student()
    {
        return $this->belongsTo(StudentRecord::class, 'studentID', 'studentID');
    }
}
