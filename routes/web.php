<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Library CRUD
Route::get('/library', 'LibraryController@index')->name('library.index');
Route::post('/library/search', 'LibraryController@search')->name('library.search');

// Skills CRUD
Route::get('/skills/{user}', 'SkillController@index')->name('skills.index');

// Courses CRUD
Route::get('/courses', 'CourseController@index')->name('courses.index');
Route::post('/courses/insert', 'CourseController@store')->name('courses.store');
Route::get('/courses/create', 'CourseController@create')->name('courses.create');
Route::get('/courses/{course}', 'CourseController@show')->name('courses.show');
Route::get('/courses/{course}/edit', 'CourseController@edit')->name('courses.edit');
Route::post('/courses/{course}/update', 'CourseController@update')->name('courses.update');

// Lessons CRUD
Route::get('/courses/{course}/lessons/create', 'LessonController@create')->name('lessons.create');
Route::post('/courses/{course}/lessons/insert', 'LessonController@store')->name('lessons.store');
Route::get('/courses/{course}/lessons/{lesson}', 'LessonController@show')->name('lessons.show');
Route::post('/courses/{course}/lessons/{lesson}/delete', 'LessonController@destroy')->name('lessons.delete');
Route::get('/courses/{course}/lessons/{lesson}/edit', 'LessonController@edit')->name('lessons.edit');
Route::post('/courses/{course}/lessons/{lesson}/update', 'LessonController@update')->name('lessons.update');

// Lectures CRUD
Route::get('/courses/{course}/lessons/{lesson}/lectures/create', 'LectureController@create')->name('lectures.create');
Route::post('/courses/{course}/lessons/{lesson}/lectures/insert', 'LectureController@store')->name('lectures.store');
Route::get('/courses/{course}/lessons/{lesson}/lectures/{lecture}', 'LectureController@show')->name('lectures.show');
Route::post('/courses/{course}/lessons/{lesson}/lectures/{lecture}/delete', 'LectureController@destroy')->name('lectures.delete');
Route::get('/courses/{course}/lessons/{lesson}/lectures/{lecture}/edit', 'LectureController@edit')->name('lectures.edit');
Route::post('/courses/{course}/lessons/{lesson}/lectures/{lecture}/update', 'LectureController@update')->name('lectures.update');
Route::post('/courses/{course}/lessons/{lesson}/lectures/{lecture}/complete', 'LectureController@complete')->name('lectures.complete');

// Questions & Answers CRUD
Route::post('/courses/{course}/lessons/{lesson}/lectures/{lecture}/questions/insert', 'QuestionController@store')->name('questions.store');
Route::post('/courses/{course}/lessons/{lesson}/lectures/{lecture}/questions/{question}/answers/insert', 'AnswerController@store')->name('answers.store');
