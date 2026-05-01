<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'course_name',
        'description',
        'price',
        'slot',
        'staff_id',
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function contents()
    {
        return $this->hasMany(CourseContent::class)->orderBy('sort_order');
    }
}
