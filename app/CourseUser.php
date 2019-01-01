<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseUser extends Model
{
    use SoftDeletes;

    protected $table = 'course_user';

    protected $dateFormat = 'Y-m-d H:i:s';

    protected $fillable = [
        'course_id',
        'user_id',
        'completed_at',
        'recertify_at',
    ];

    protected $dates = [
        'recertify_at',
        'completed_at',
        'deleted_at',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        parent::creating(function(CourseUser $record){

            $record->author_id = auth()->user()->id;

        });
    }

    public function scopeMine($query)
    {
        return $query->where('user_id', auth()->user()->id);
    }

    public function author()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
