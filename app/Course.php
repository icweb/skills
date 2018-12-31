<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use SoftDeletes;

    protected $dateFormat = 'Y-m-d H:i:s';

    protected $fillable = [
        'title',
        'slug',
        'short_description',
        'long_description',
        'recertify_interval',
    ];

    protected $dates = [
        'deleted_at',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        parent::creating(function(Course $record){

            $record->author_id = auth()->user()->id;

        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function isCompleted()
    {
        $lessons = $this->assignedLessons()->get();
        $final_status = true;

        foreach($lessons as $lesson)
        {
            if(!$lesson->lesson->isCompleted(false))
            {
                $final_status = false;
                break;
            }
        }

        return $final_status;
    }

    public function skills()
    {
        $lesson_ids = CourseLesson::select('lesson_id')->where('course_id', $this->id)->get()->pluck('lesson_id')->toArray();
        $skill_ids = LessonSkill::select('skill_id')->whereIn('lesson_id', $lesson_ids)->get()->pluck('skill_id')->toArray();

        return Skill::whereIn('id', $skill_ids)->get();
    }

    public function author()
    {
        return $this->belongsTo(User::class);
    }

    public function assignedLessons()
    {
        return $this->hasMany(CourseLesson::class, 'course_id');
    }

    public function assignedUsers()
    {
        return $this->hasMany(CourseUser::class, 'course_id');
    }
}
