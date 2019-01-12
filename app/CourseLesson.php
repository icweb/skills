<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseLesson extends Model
{
    use SoftDeletes;

    protected $table = 'course_lesson';

    protected $dateFormat = 'Y-m-d H:i:s';

    protected $fillable = [
        'lesson_id',
        'course_id',
        'position',
    ];

    protected $dates = [
        'deleted_at',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        parent::creating(function(CourseLesson $record){

            $record->author_id = auth()->user()->id;

        });
    }

    public function next()
    {
        $next_position = CourseLesson::where('position', '>', $this->position)->min('position');
        $previous_position = CourseLesson::where('position', '<', $this->position)->max('position');

        $next = CourseLesson::where(['position' => $next_position, 'course_id' => $this->course_id])->first();
        $previous = CourseLesson::where(['position' => $previous_position, 'course_id' => $this->course_id])->first();

        return (object) [
            'next'      => isset($next) ? $next->lesson : '',
            'previous'  => isset($previous) ? $previous->lesson : '',
        ];
    }

    public function author()
    {
        return $this->belongsTo(User::class);
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class, 'lesson_id', 'id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
