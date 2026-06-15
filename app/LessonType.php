<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LessonType extends Model
{
    protected $fillable = [
        'key',
        'label',
        'columns',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'columns'   => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * The pool of physical columns available in the `lesson_records` table.
     * Admin builds a new lesson type by picking from these (and giving each a
     * display label + choosing text/dropdown). Reuses existing storage so no
     * new migration is needed when a type is added.
     *
     *   key  => [default label, default field type]
     */
    public static $pool = [
        'attendance'    => ['Attendance',    'dropdown'],
        'course'        => ['Course',        'dropdown'],
        'para_name'     => ['Para Name',     'dropdown'],
        'surah_name'    => ['Surah Name',    'dropdown'],
        'tekhti_number'  => ['Tekhti Number',  'dropdown'],
        'select_lesson' => ['Select Lesson', 'dropdown'],
        'page_number'   => ['Page No',       'text'],
        'ayat_from'     => ['Ayat From',     'text'],
        'ayat_to'       => ['Ayat To',       'text'],
        'line_from'     => ['Line From',     'text'],
        'line_to'       => ['Line To',       'text'],
        'notes'         => ['Notes',         'dropdown'],
    ];

    /**
     * Active types as [key => label] (for dropdowns / labels everywhere).
     */
    public static function types()
    {
        return static::where('is_active', 1)
            ->orderBy('sort_order')->orderBy('label')
            ->pluck('label', 'key')
            ->toArray();
    }

    /**
     * The column config array for a given type key (without the leading date col).
     */
    public static function columnsFor($key)
    {
        $lt = static::where('key', $key)->first();
        return ($lt && is_array($lt->columns)) ? $lt->columns : [];
    }
}
