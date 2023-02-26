<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AvailableCourse extends Model
{
    use HasFactory;
    protected $fillable = ['course_id','semester_id'];

    public function Course(){
        return $this->hasOne(Course::class,'id');
    }
    public function Semester()
    {
        return $this->hasOne(Semester::class, 'semester_id');
    }

    public function Enrollments()
    {
        return $this->belongsTo(Enrollment::class, 'available_course_id','id');
    }


}

