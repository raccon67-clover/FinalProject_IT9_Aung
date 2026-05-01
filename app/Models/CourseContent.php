<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseContent extends Model
{
    protected $fillable = [
        'course_id',
        'title',
        'body',
        'video_url',
        'sort_order',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function completedByUsers()
    {
        return $this->belongsToMany(User::class, 'course_content_user')->withTimestamps();
    }
}
