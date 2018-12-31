<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('skills', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('author_id');
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('color')->default('#000000');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('courses', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('author_id');
            $table->unsignedInteger('recertify_interval')->default(0);
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('short_description');
            $table->longText('long_description');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('lessons', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('author_id');
            $table->string('title');
            $table->string('slug')->unique();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('lectures', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('author_id');
            $table->enum('type', ['Quiz', 'Article', 'Download'])->default('Article');
            $table->string('title');
            $table->string('slug')->unique();
            $table->timestamps();
            $table->softDeletes();
        });

        // A list of lessons a course should be assigned
        Schema::create('course_lesson', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('author_id');
            $table->unsignedInteger('course_id');
            $table->unsignedInteger('lesson_id');
            $table->timestamps();
            $table->softDeletes();
        });

        // A list of lectures a lesson should be assigned to
        Schema::create('lecture_lesson', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('author_id');
            $table->unsignedInteger('lecture_id');
            $table->unsignedInteger('lesson_id');
            $table->timestamps();
            $table->softDeletes();
        });

        // A list of users who are assigned to the course
        Schema::create('course_user', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('author_id');
            $table->unsignedInteger('course_id');
            $table->unsignedInteger('user_id');
            $table->timestamp('recertify_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // A list of users and the lessons they completed
        Schema::create('lesson_user', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('lesson_id');
            $table->unsignedInteger('user_id');
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // A list of users and the lectures they completed
        Schema::create('lecture_user', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('lecture_id');
            $table->unsignedInteger('user_id');
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // A list of skills you can earn by completing each lesson
        Schema::create('lesson_skill', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('author_id');
            $table->unsignedInteger('lesson_id');
            $table->unsignedInteger('skill_id');
            $table->timestamps();
            $table->softDeletes();
        });

        // A list of users and the skills they have earned
        Schema::create('skill_user', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('skill_id');
            $table->unsignedInteger('user_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
