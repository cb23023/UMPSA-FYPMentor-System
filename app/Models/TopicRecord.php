<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopicRecord extends Model
{
    use HasFactory;

    protected $primaryKey = 'topicID';
    protected $table = 'topic_records';


    protected $fillable = [
        'title',
        'description',
        'status',
        'lecturerID',
        'studentID',
        'is_custom'
    ];

    public function lecturer()
    {
        return $this->belongsTo(LecturerRecord::class, 'lecturerID', 'lecturerID');
    }
    public function student()
    {
        return $this->belongsTo(StudentRecord::class, 'studentID', 'studentID');
    }
}
