<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Lecture extends Model
{
    use SoftDeletes;

    protected $dateFormat = 'Y-m-d H:i:s';

    protected $fillable = [
        'type',
        'title',
        'slug',
        'body',
        'completion_time',
        'file_id',
    ];

    protected $dates = [
        'deleted_at',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        parent::creating(function(Lecture $record){

            $record->author_id = auth()->user()->id;

        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function isCompleted()
    {
        $lecture_user = $this->assignedUsers()
            ->where('user_id', auth()->user()->id)
            ->orderBy('id', 'desc')
            ->first();

        return isset($lecture_user->completed_at);
    }

    public static function types()
    {
        return ['Quiz', 'Article', 'Download'];
    }

    public function completionHistory()
    {
        return $this->assignedUsers()
            ->where('user_id', auth()->user()->id)
            ->whereNotNull('completed_at')
            ->orderBy('id', 'desc')
            ->get();
    }

    public function removeFileIfExists()
    {
        if(isset($this->file->id))
        {
            Storage::delete($this->file->path);
            $this->file->forceDelete();
        }
    }

    public function hasSkill($skill_id)
    {
        return $this->assignedSkills()->where('skill_id', $skill_id)->get()->count() > 0;
    }

    public function author()
    {
        return $this->belongsTo(User::class);
    }

    public function assignedLessons()
    {
        return $this->hasMany(LectureLesson::class, 'lesson_id');
    }

    public function assignedUsers()
    {
        return $this->hasMany(LectureUser::class, 'lecture_id');
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function file()
    {
        return $this->hasOne(File::class);
    }

    public function assignedSkills()
    {
        return $this->hasMany(LectureSkill::class, 'lecture_id');
    }
}
