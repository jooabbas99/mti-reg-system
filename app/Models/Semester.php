<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    use HasFactory;
    public function AvCourses(){
        return $this->hasMany(AvailableCourse::class,'semester_id');
    }

    // public function Courses()
    // {
    //     return $this->hasOneThrough(Course::class, AvailableCourse::class, 'id', 'course_id', 'available_course_id', 'id');
    // }
}
