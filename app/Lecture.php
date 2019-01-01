<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
}
