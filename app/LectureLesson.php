<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class LectureLesson extends Model implements Sortable
{
    use SoftDeletes, SortableTrait;

    protected $table = 'lecture_lesson';

    protected $dateFormat = 'Y-m-d H:i:s';

    protected $fillable = [
        'lesson_id',
        'lecture_id',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public $sortable = [
        'order_column_name' => 'position',
        'sort_when_creating' => true,
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        parent::creating(function(LectureLesson $record){

            $record->author_id = auth()->user()->id;

        });
    }

    public function next()
    {
        $next_position = LectureLesson::where('position', '>', $this->position)->min('position');
        $previous_position = LectureLesson::where('position', '<', $this->position)->max('position');

        $next = LectureLesson::where(['position' => $next_position, 'lesson_id' => $this->lesson_id])->first();
        $previous = LectureLesson::where(['position' => $previous_position, 'lesson_id' => $this->lesson_id])->first();

        return (object) [
            'next'      => isset($next) ? $next->lecture : '',
            'previous'  => isset($previous) ? $previous->lecture : '',
        ];
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
