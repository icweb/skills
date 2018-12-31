<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LessonSkill extends Model
{
    use SoftDeletes;

    protected $table = 'lesson_skill';

    protected $dateFormat = 'Y-m-d H:i:s';

    protected $fillable = [
        'lesson_id',
        'skill_id',
    ];

    protected $dates = [
        'deleted_at',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        parent::creating(function(LessonSkill $record){

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

    public function skill()
    {
        return $this->belongsTo(Skill::class);
    }
}
