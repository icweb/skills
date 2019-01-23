<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuizScore extends Model
{
    use SoftDeletes;

    protected $dateFormat = 'Y-m-d H:i:s';

    protected $fillable = [
        'lecture_id',
        'user_id',
        'available',
        'answered',
        'correct',
        'incorrect',
        'status',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $appends = [
        'score',
        'pass',
    ];

    public function getScoreAttribute()
    {
        return round(($this->correct/$this->available) * 100, 2);
    }

    public function getPassAttribute()
    {
        return round(($this->correct/$this->available) * 100, 2) > $this->lecture->quiz_required_score;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lecture()
    {
        return $this->belongsTo(Lecture::class);
    }
}
