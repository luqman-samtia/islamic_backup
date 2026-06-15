<?php

// namespace Database\Seeds;

use Illuminate\Database\Seeder;
use App\LessonOption;

class LessonOptionsSeeder extends Seeder
{
    public function run()
    {
        $attendance = ['Present', 'Absent', 'Leave', 'Late'];
        $notes      = ['Good', 'Excellent', 'Needs Practice', 'Revise', 'Homework Given'];

        // Common to all types: attendance + notes
        foreach (['quran', 'qaida', 'namaz'] as $type) {
            foreach ($attendance as $i => $label) {
                $this->add($type, 'attendance', $label, $i);
            }
            foreach ($notes as $i => $label) {
                $this->add($type, 'notes', $label, $i);
            }
        }

        // Quran: 30 Para names
        for ($p = 1; $p <= 30; $p++) {
            $this->add('quran', 'para_name', 'Para ' . $p, $p);
        }

        // Quran: a few common surahs (admin can add the rest from the UI)
        $surahs = ['Al-Fatiha', 'Al-Baqarah', 'Aal-e-Imran', 'An-Nisa', 'Al-Maidah', 'Yaseen', 'Ar-Rahman', 'Al-Mulk'];
        foreach ($surahs as $i => $s) {
            $this->add('quran', 'surah_name', $s, $i);
        }

        // Qaida: Tekhti numbers 1-30
        for ($t = 1; $t <= 30; $t++) {
            $this->add('qaida', 'tekhti_number', 'Tekhti ' . $t, $t);
        }

        // Namaz / Kalmay / Duain: common lessons
        $namaz = [
            'Kalma Tayyab', 'Kalma Shahadat', 'Kalma Tamjeed', 'Kalma Tauheed',
            'Kalma Astaghfar', 'Kalma Radde Kufr',
            'Wudu', 'Namaz Niyyat', 'Sana', 'Tashahhud', 'Durood Ibrahim',
            'Dua-e-Qunoot', 'Dua before sleeping', 'Dua after eating',
        ];
        foreach ($namaz as $i => $n) {
            $this->add('namaz', 'select_lesson', $n, $i);
        }
    }

    protected function add($type, $field, $label, $sort = 0)
    {
        LessonOption::firstOrCreate(
            ['lesson_type' => $type, 'field_key' => $field, 'label' => $label],
            ['sort_order' => $sort]
        );
    }
}
