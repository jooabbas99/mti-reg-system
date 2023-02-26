<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->string('username')->nullable();
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->longText('module')->nullable();
            $table->date('birthdate')->nullable();
            $table->string('image')->nullable();
            $table->rememberToken();
            $table->string('oauth_provider')->nullable();
            $table->string('oauth_uid')->nullable();
            $table->string('gender')->nullable();
            $table->string('locale')->nullable();
            $table->string('link')->nullable();
            $table->enum('login_type', ['1', '2'])->nullable();
            $table->tinyInteger('image_flag')->nullable()->default(0);
            $table->integer('role')->default(0);
            $table->enum('status', ['0', '1']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
