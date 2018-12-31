<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lesson extends Model
{
    use SoftDeletes;

    protected $dateFormat = 'Y-m-d H:i:s';

    protected $fillable = [
        'title',
        'slug',
    ];

    protected $dates = [
        'deleted_at',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        parent::creating(function(Lesson $record){

            $record->author_id = auth()->user()->id;

        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function isCompleted($user)
    {
        if(!$user) $user = auth()->user()->id;

        $lectures = $this->assignedLectures()->get();
        $final_status = true;

        foreach($lectures as $lecture)
        {
            $is_completed = LectureUser::where(['lecture_id' => $lecture->id, 'user_id' => $user])
                ->whereNotNull('completed_at')
                ->get()
                ->count();

            if(!$is_completed)
            {
                $final_status = false;
                break;
            }
        }

        return $final_status;
    }

    public function author()
    {
        return $this->belongsTo(User::class);
    }

    public function assignedCourses()
    {
        return $this->hasMany(CourseLesson::class, 'lesson_id');
    }

    public function assignedLectures()
    {
        return $this->hasMany(LectureLesson::class, 'lesson_id');
    }

    public function assignedUsers()
    {
        return $this->hasMany(LessonUser::class, 'lesson_id');
    }

    public function assignedSkills()
    {
        return $this->hasMany(LessonSkill::class, 'lesson_id');
    }
}
