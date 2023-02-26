<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAvailableCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('available_courses', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('course_id')->nullable();
            $table->foreign('course_id')->references('id')->on('courses');

            $table->unsignedBigInteger('semester_id')->nullable();
            $table->foreign('semester_id')->references('id')->on('semesters');

            $table->boolean('is_available')->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('available_courses');
    }
}
