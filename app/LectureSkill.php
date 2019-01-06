<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LectureSkill extends Model
{
    use SoftDeletes;

    protected $table = 'lecture_skill';

    protected $dateFormat = 'Y-m-d H:i:s';

    protected $fillable = [
        'lecture_id',
        'skill_id',
    ];

    protected $dates = [
        'deleted_at',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        parent::creating(function(LectureSkill $record){

            $record->author_id = auth()->user()->id;

        });
    }

    public function author()
    {
        return $this->belongsTo(User::class);
    }

    public function lecture()
    {
        return $this->belongsTo(Lecture::class);
    }

    public function skill()
    {
        return $this->belongsTo(Skill::class);
    }
}
