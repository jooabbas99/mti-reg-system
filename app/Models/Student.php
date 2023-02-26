<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    public function Enrollments(){
        return $this->hasMany(Enrollment::class,'student_id');
    }
    public function User()
    {
        return $this->hasOne(User::class, 'user_id');
    }
}
