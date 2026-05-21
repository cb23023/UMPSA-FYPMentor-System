<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentRecord extends Model
{
    use HasFactory;
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function topics()
    {
        return $this->belongsTo(TopicRecord::class, 'studentID', 'studentID');
    }

    protected $fillable = [
        'studentID',
        'user_id',
        'name',
        'course',
    ];
}
