<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LecturerRecord extends Model
{
    use HasFactory;

    protected $primaryKey = 'lecturerID';
    public $incrementing = false;
    protected $keyType = 'string';
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); // 'user_id' is the foreign key in lecturer_records
    }

    protected $fillable = [
        'lecturerID',
        'user_id',
        'name',
        'numberQuota',
        'current_students',
        'accepting_students',
        'profilePicture',
        'timetable'
    ];

    public function topics()
    {
        return $this->hasMany(TopicRecord::class, 'lecturerID', 'lecturerID');
    }

    public function appointments()
    {
        return $this->hasMany(AppointmentRecord::class, 'lecturerID', 'lecturerID');
    }
}
