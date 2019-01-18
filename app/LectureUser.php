<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LectureUser extends Model
{
    use SoftDeletes;

    protected $table = 'lecture_user';

    protected $dateFormat = 'Y-m-d H:i:s';

    protected $fillable = [
        'lecture_id',
        'user_id',
        'completed_at',
    ];

    protected $dates = [
        'completed_at',
        'recertify_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function scopeMine($query)
    {
        return $query->where('user_id', auth()->user()->id);
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
