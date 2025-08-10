<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Sprint extends Model
{
    //
    protected $table = 'sprints';

    protected $primaryKey = 'sprint_uid';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->sprint_uid)) {
                $model->sprint_uid = (string) Str::uuid();
            }
        });
    }

    public function project()
    {
        return $this->belongsTo(Project::class, "project_uid", "project_uid");
    }

    public function task()
    {
        return $this->hasMany(Task::class, "sprint_uid", "sprint_uid");
    }

    public function owner()
    {
        return $this->belongsTo(User::class, "owner_uid", "user_uid");
    }
}
