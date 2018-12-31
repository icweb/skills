<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SkillUser extends Model
{
    use SoftDeletes;

    protected $table = 'skill_user';

    protected $dateFormat = 'Y-m-d H:i:s';

    protected $fillable = [
        'skill_id',
        'user_id',
    ];

    protected $dates = [
        'deleted_at',
    ];

    public function skill()
    {
        return $this->belongsTo(Skill::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
