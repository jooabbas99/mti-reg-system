<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;
    protected $fillable = [
        'available_course_id',
        'student_id',
        'status',
    ];			


    public function AvCourse()
    {
        return $this->hasOne(Course::class, 'id','available_course_id');
    }
    public function Student()
    {
        return $this->hasOne(Student::class,'id', 'student_id');
    }
    public function Semester()
    {
        return $this->hasOneThrough(Semester::class, AvailableCourse::class,'id','id', 'available_course_id', 'semester_id');
    }
    public function Course()
    {
        //  'id','course_id', 'available_course_id', 'id'
        return $this->hasOneThrough(Course::class, AvailableCourse::class,'id','id', 'available_course_id','course_id');
    }
}
