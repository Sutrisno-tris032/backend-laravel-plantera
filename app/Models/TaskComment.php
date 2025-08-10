<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskComment extends Model
{
    //
     protected $guarded = [];

     public function task() {
        return $this->belongsTo(Task::class, "task_uid", "task_uid");
     }

     public function user() {
        return $this->belongsTo(User::class, "user_uid", "user_uid");
     }
}
