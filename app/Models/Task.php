<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Task extends Model
{
   //
   protected $table = "tasks";

   protected $primaryKey = 'task_uid';

   protected $keyType = 'string';

   public $incrementing = false;

   protected $guarded = [];

   // Event model untuk generate UUID otomatis
   protected static function boot()
   {
      parent::boot();

      static::creating(function ($model) {
         if (empty($model->task_uid)) {
            $model->task_uid = (string) Str::uuid();
         }
      });
   }

   public function sprint()
   {
      return $this->belongsTo(Sprint::class, "sprint_uid", "sprint_uid");
   }

   public function project()
   {
      return $this->belongsTo(Project::class, "project_uid", "project_uid");
   }

   //   public function assignee() {
   //      return $this->belongsTo(User::class, "assign_uid", "user_uid");
   //   }

   public function comment()
   {
      return $this->hasMany(TaskComment::class, "task_uid", "task_uid");
   }
}
