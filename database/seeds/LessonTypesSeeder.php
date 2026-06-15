<?php

// namespace Database\seeds;

use Illuminate\Database\Seeder;
use App\LessonType;

class LessonTypesSeeder extends Seeder
{
    public function run()
    {
        $types = [
            [
                'key'        => 'quran',
                'label'      => 'Quran',
                'sort_order' => 1,
                'columns'    => [
                    ['key' => 'attendance',  'label' => 'Attendance', 'type' => 'dropdown'],
                    ['key' => 'course',      'label' => 'Course',     'type' => 'dropdown'],
                    ['key' => 'para_name',   'label' => 'Para Name',  'type' => 'dropdown'],
                    ['key' => 'surah_name',  'label' => 'Surah Name', 'type' => 'dropdown'],
                    ['key' => 'page_number', 'label' => 'Page No',    'type' => 'text'],
                    ['key' => 'ayat_from',   'label' => 'Ayat From',  'type' => 'text'],
                    ['key' => 'ayat_to',     'label' => 'Ayat To',    'type' => 'text'],
                    ['key' => 'notes',       'label' => 'Notes',      'type' => 'dropdown'],
                ],
            ],
            [
                'key'        => 'qaida',
                'label'      => 'Qaida',
                'sort_order' => 2,
                'columns'    => [
                    ['key' => 'attendance',   'label' => 'Attendance',   'type' => 'dropdown'],
                    ['key' => 'course',       'label' => 'Course',       'type' => 'dropdown'],
                    ['key' => 'tekhti_number', 'label' => 'Tekhti Number', 'type' => 'dropdown'],
                    ['key' => 'page_number',  'label' => 'Page No',      'type' => 'text'],
                    ['key' => 'line_from',    'label' => 'Line From',    'type' => 'text'],
                    ['key' => 'line_to',      'label' => 'Line To',      'type' => 'text'],
                    ['key' => 'notes',        'label' => 'Notes',        'type' => 'dropdown'],
                ],
            ],
            [
                'key'        => 'namaz',
                'label'      => 'Namaz / Kalmay / Duain',
                'sort_order' => 3,
                'columns'    => [
                    ['key' => 'attendance',    'label' => 'Attendance',    'type' => 'dropdown'],
                    ['key' => 'course',        'label' => 'Course',        'type' => 'dropdown'],
                    ['key' => 'select_lesson', 'label' => 'Select Lesson', 'type' => 'dropdown'],
                    ['key' => 'page_number',   'label' => 'Page No',       'type' => 'text'],
                    ['key' => 'line_from',     'label' => 'Line From',     'type' => 'text'],
                    ['key' => 'line_to',       'label' => 'Line To',       'type' => 'text'],
                    ['key' => 'notes',         'label' => 'Notes',         'type' => 'dropdown'],
                ],
            ],
        ];

        foreach ($types as $t) {
            LessonType::updateOrCreate(
                ['key' => $t['key']],
                [
                    'label'      => $t['label'],
                    'columns'    => $t['columns'],
                    'is_active'  => true,
                    'sort_order' => $t['sort_order'],
                ]
            );
        }
    }
}
