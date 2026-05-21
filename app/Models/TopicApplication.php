<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopicApplication extends Model
{
    use HasFactory;

    protected $fillable = ['topicID', 'studentID', 'status', 'remarks'];

    public function topic()
    {
        return $this->belongsTo(TopicRecord::class, 'topicID', 'topicID');
    }

    public function student()
    {
        return $this->belongsTo(StudentRecord::class, 'studentID', 'studentID');
    }
}
