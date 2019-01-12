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
            $table->string('icon')->default('circle-o');
            $table->string('title');
            $table->longText('description');
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
            $table->string('color')->default('#000000');
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
            $table->unsignedInteger('show_in_search')->default(1);
            $table->unsignedInteger('allow_print')->default(1);
            $table->unsignedInteger('completion_time')->default(0);
            $table->enum('type', ['Quiz', 'Article', 'Download', 'Video'])->default('Article');
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('body')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('files', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('lecture_id');
            $table->unsignedInteger('author_id');
            $table->unsignedInteger('size')->nullable();
            $table->string('title');
            $table->string('extension');
            $table->string('full_name');
            $table->string('path');
            $table->timestamps();
            $table->softDeletes();
        });

        // A list of lessons a course should be assigned
        Schema::create('course_lesson', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('author_id');
            $table->unsignedInteger('course_id');
            $table->unsignedInteger('lesson_id');
            $table->unsignedInteger('position');
            $table->timestamps();
            $table->softDeletes();
        });

        // A list of lectures a lesson should be assigned to
        Schema::create('lecture_lesson', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('author_id');
            $table->unsignedInteger('lecture_id');
            $table->unsignedInteger('lesson_id');
            $table->unsignedInteger('position');
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
        Schema::create('lecture_skill', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('author_id');
            $table->unsignedInteger('lecture_id');
            $table->unsignedInteger('skill_id');
            $table->timestamps();
            $table->softDeletes();
        });

        // A list of users and the skills they have earned
        Schema::create('skill_user', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('skill_id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('time_earned');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('questions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('author_id');
            $table->unsignedInteger('lecture_id');
            $table->unsignedInteger('answer_id')->nullable();
            $table->string('title');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('answers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('author_id');
            $table->unsignedInteger('question_id');
            $table->string('title');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('lecture_favorites', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('lecture_id');
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
