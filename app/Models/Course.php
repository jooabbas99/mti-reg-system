<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    public function Prerequisite(){
        return $this->hasOne(Course::class, 'id', 'pre_course_id');
    }
    public function isAssigned($semester_id)
    {
        return AvailableCourse::where('course_id','=',$this->id)->where('semester_id','=', $semester_id)->exists();
    }
}
