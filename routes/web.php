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

Route::get('/skills', 'SkillController@index')->name('skills.index');

Route::get('/courses', 'CourseController@index')->name('courses.index');
Route::post('/courses/insert', 'CourseController@store')->name('courses.store');
Route::get('/courses/create', 'CourseController@create')->name('courses.create');
Route::get('/courses/{course}', 'CourseController@show')->name('courses.show');

Route::get('/courses/{course}/lessons/{lesson}/lectures/{lecture}', 'LectureController@show')->name('lectures.show');

Route::post('/courses/{course}/lessons/{lesson}/lectures/{lecture}/complete', 'LectureController@complete')->name('lectures.complete');
