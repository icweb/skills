<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use SoftDeletes;

    protected $dateFormat = 'Y-m-d H:i:s';

    protected $fillable = [
        'title',
        'lecture_id',
        'answer_id',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        parent::creating(function(Question $record){

            $record->author_id = auth()->user()->id;

        });
    }

    public function author()
    {
        return $this->belongsTo(User::class);
    }

    public function rightAnswer()
    {
        return $this->hasOne(Answer::class, 'id', 'answer_id');
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function lecture()
    {
        return $this->belongsTo(Lecture::class);
    }
}
