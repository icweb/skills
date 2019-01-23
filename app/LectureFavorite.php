<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LectureFavorite extends Model
{
    use SoftDeletes;

    protected $table = 'lecture_favorites';

    protected $dateFormat = 'Y-m-d H:i:s';

    protected $fillable = [
        'lecture_id',
        'user_id',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function lecture()
    {
        return $this->belongsTo(Lecture::class);
    }
}
