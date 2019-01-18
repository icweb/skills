<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LessonUser extends Model
{
    use SoftDeletes;

    protected $table = 'lesson_user';

    protected $dateFormat = 'Y-m-d H:i:s';

    protected $fillable = [
        'lesson_id',
        'user_id',
        'completed_at',
    ];

    protected $dates = [
        'completed_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
