<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class LessonRecord extends Model
{
    protected $fillable = [
        'user_id', 'lesson_type', 'lesson_date', 'day',
        'attendance', 'course',
        'para_name', 'surah_name', 'ayat_from', 'ayat_to',
        'tekhti_number',
        'select_lesson',
        'page_number', 'line_from', 'line_to', 'notes',
        'created_by', 'creator_role',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Column layout for a lesson type.
     * Types are now admin-managed (App\LessonType). The leading "Day & Date"
     * column is always present; the rest come from the type's saved config.
     *
     * type: dropdown  -> <select> built from lesson_options (+ add item)
     * type: text      -> plain input
     * type: date      -> date + auto day
     */
    public static function columns($type)
    {
        $base = [
            ['key' => 'lesson_date', 'label' => 'Day & Date', 'type' => 'date'],
        ];

        $custom = \App\LessonType::columnsFor($type);

        return array_merge($base, $custom);
    }
}
