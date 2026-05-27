<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
      'user_id',
      'category_id',
      'title',
      'author',
      'cover_image',
      'file_path',
      'description',
      'access_type',
      'price',
      'status',
      'rejection_reason'
    ];

    public function category() {
      return $this->belongsTo(Category::class);
    }

    public function user() {
    return $this->belongsTo(User::class);
    }

    public function activityLogs() {
        return $this->hasMany(ActivityLog::class);
    }

    public function downloads()
    {
        return $this->hasMany(ActivityLog::class)->where('action', 'downloaded');
    }
}
