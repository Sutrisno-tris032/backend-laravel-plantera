<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Project extends Model
{
   //
   protected $table = 'projects';

   protected $primaryKey = 'project_uid';

   protected $keyType = 'string';

   public $incrementing = false;

   protected $guarded = [];

   // protected $fillable = [
   //    'project_name',
   //    'description',
   //    'start_date',
   //    'end_date',
   //    'owner_uid',
   //    'status_id',
   //    'status_name',
   //    'project_uid',
   //    'created_at',
   //    'updated_at'
   // ];

   // Event model untuk generate UUID otomatis
   protected static function boot()
   {
      parent::boot();

      static::creating(function ($model) {
         if (empty($model->project_uid)) {
            $model->project_uid = (string) Str::uuid();
         }
      });
   }


   public function sprint()
   {
      return $this->hasMany(Sprint::class, "project_uid", "project_uid");
   }

   //   public function owner(): HasMany {
   //      return $this->hasMany(User::class, "owner_uid", "user_uid");
   //   }

   public function task()
   {
      return $this->hasMany(Task::class, "project_uid", "sprint_uid");
   }
}
