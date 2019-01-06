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

    public function completionTime()
    {
        $lesson_ids = $this->assignedLessons()
            ->select('lesson_id')
            ->get()
            ->pluck('lesson_id')
            ->toArray();

        $lecture_ids = LectureLesson::select('lecture_id')
            ->whereIn('lesson_id', $lesson_ids)
            ->get()
            ->pluck('lecture_id')
            ->toArray();

        $lectures = Lecture::whereIn('id', $lecture_ids)->get();

        $total_seconds = 0;

        foreach($lectures as $lecture)
        {
            $total_seconds += $lecture->completion_time;
        }

        $total_minutes = round($total_seconds / 60);
        $total_hours = round($total_minutes / 60);
        $total_days = round($total_hours / 24);
        $total_years = round($total_days / 365);

        if($total_seconds === 0)
        {
            return '';
        }
        else if($total_days >= 365)
        {
            return $total_years . ($total_years === 1 ? ' year' : ' years');
        }
        else if($total_hours >= 24)
        {
            return $total_days . ($total_days === 1 ? ' day' : ' days');
        }
        if($total_minutes >= 60)
        {
            return $total_hours . ($total_hours === 1 ? ' hour' : ' hours');
        }
        else if($total_minutes >= 1)
        {
            return $total_minutes . ($total_minutes === 1 ? ' minute' : ' minutes');
        }
        else
        {
            return $total_seconds . ($total_seconds === 1 ? ' second' : ' seconds');
        }


    }

    public function skills()
    {
        $lesson_ids = CourseLesson::select('lesson_id')->where('course_id', $this->id)->get()->pluck('lesson_id')->toArray();
        $lecture_ids = LectureLesson::select('lecture_id')->whereIn('lesson_id', $lesson_ids)->get()->pluck('lecture_id')->toArray();
        $skill_ids = LectureSkill::select('skill_id')->whereIn('lecture_id', $lecture_ids)->get()->pluck('skill_id')->toArray();

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
