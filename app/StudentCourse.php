<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentCourse extends Model
{
    protected $fillable = [
        'user_id',
        'lesson_type',
        'course_name',
        'scholar_can_write',
        'student_can_write',
        'is_active',
    ];

    protected $casts = [
        'scholar_can_write' => 'boolean',
        'student_can_write' => 'boolean',
        'is_active'         => 'boolean',
    ];

    /**
     * Lesson types are now admin-managed (App\LessonType).
     * Returns [key => label] of active types. Kept here so existing
     * references (StudentCourse::types()) keep working.
     */
    public static function types()
    {
        return \App\LessonType::types();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
