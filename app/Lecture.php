<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Laravel\Scout\Searchable;

class Lecture extends Model
{
    use SoftDeletes, Searchable;

    protected $dateFormat = 'Y-m-d H:i:s';

    protected $fillable = [
        'type',
        'title',
        'slug',
        'body',
        'completion_time',
        'file_id',
        'show_in_search',
        'allow_print',
    ];

    protected $dates = [
        'deleted_at',
    ];

    public function toSearchableArray()
    {
        $array = $this->toArray();

        array_push($array, 'title');
        array_push($array, 'body');
        array_push($array, 'slug');

        return $array;
    }

    public function shouldBeSearchable()
    {
        return $this->visible();
    }

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

    public function scopeVisible($query)
    {
        return $query->where('show_in_search', 1);
    }

    public function isCompleted()
    {
        $lecture_user = $this->assignedUsers()
            ->where('user_id', auth()->user()->id)
            ->orderBy('id', 'desc')
            ->first();

        return isset($lecture_user->completed_at);
    }

    public function isFavorite()
    {
        $lecture_favorites = LectureFavorite::where(['user_id' => auth()->user()->id, 'lecture_id' => $this->id])->get();
        return count($lecture_favorites);
    }

    public static function types($withIcons = false)
    {
        if($withIcons)
        {
            return [
                'Quiz'      => 'play-circle',
                'Article'   => 'file-o',
                'Download'  => 'download',
            ];
        }
        else
        {
            return ['Quiz', 'Article', 'Download'];
        }
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
