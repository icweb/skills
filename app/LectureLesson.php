<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LectureLesson extends Model
{
    use SoftDeletes;

    protected $table = 'lecture_lesson';

    protected $dateFormat = 'Y-m-d H:i:s';

    protected $fillable = [
        'lesson_id',
        'lecture_id',
    ];

    protected $dates = [
        'deleted_at',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        parent::creating(function(LectureLesson $record){

            $record->author_id = auth()->user()->id;

        });
    }

    public function author()
    {
        return $this->belongsTo(User::class);
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function lecture()
    {
        return $this->belongsTo(Lecture::class);
    }
}
