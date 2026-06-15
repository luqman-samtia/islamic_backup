<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LessonOption extends Model
{
    protected $fillable = [
        'lesson_type',
        'field_key',
        'label',
        'sort_order',
    ];

    /**
     * Which dropdown ("Add Item") fields exist for a lesson type.
     * Derived from the type's saved column config (App\LessonType): every
     * column whose type is "dropdown" becomes a manageable option list.
     * Returns [field_key => display label].
     */
    public static function fieldsFor($type)
    {
        $cols = \App\LessonType::columnsFor($type);

        $out = [];
        foreach ($cols as $c) {
            if (($c['type'] ?? '') === 'dropdown') {
                $out[$c['key']] = $c['label'] ?? $c['key'];
            }
        }

        return $out;
    }
}
