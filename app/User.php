<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function assignedCourses()
    {
        return $this->hasMany(CourseUser::class, 'user_id');
    }

    public function favorites()
    {
        return $this->hasMany(LectureFavorite::class, 'user_id', 'id');
    }

    public function assignedLessons()
    {
        return $this->hasMany(LessonUser::class, 'user_id');
    }

    public function assignedLectures()
    {
        return $this->hasMany(LectureUser::class, 'user_id');
    }
}
