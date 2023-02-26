<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnrollmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->unsignedBigInteger('available_course_id')->nullable();
            $table->foreign('available_course_id')->references('id')->on('available_courses');

            $table->unsignedBigInteger('student_id')->nullable();
            $table->foreign('student_id')->references('id')->on('students');

            $table->enum('semester', ['A', 'P', 'C','R'])->default('P');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('enrollments');
    }
}
