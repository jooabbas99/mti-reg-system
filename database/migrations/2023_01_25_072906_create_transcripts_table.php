<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTranscriptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transcripts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->unsignedBigInteger('course_id')->nullable();
            $table->foreign('course_id')->references('id')->on('courses');

            $table->unsignedBigInteger('student_id')->nullable();
            $table->foreign('student_id')->references('id')->on('students');

            $table->float('grade')->nullable();
            $table->string('semester')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transcripts');
    }
}
