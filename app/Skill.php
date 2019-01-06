<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Skill extends Model
{
    use SoftDeletes;

    protected $dateFormat = 'Y-m-d H:i:s';

    protected $fillable = [
        'title',
        'color',
        'slug',
    ];

    protected $dates = [
        'deleted_at',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        parent::creating(function(Skill $record){

            $record->author_id = auth()->user()->id;

        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function author()
    {
        return $this->belongsTo(User::class);
    }

    public function assignedUsers()
    {
        return $this->hasMany(SkillUser::class, 'skill_id', 'id');
    }

    public function assignedLectures()
    {
        return $this->hasMany(LectureSkill::class, 'skill_id', 'id');
    }
}
