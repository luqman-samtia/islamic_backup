<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Scholars;
use App\LessonRecord;
use App\LessonOption;
use App\LessonType;
use App\StudentCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class LessonController extends Controller
{
    /* =========================================================
     |  HELPERS
     |=========================================================*/

    // The role of the logged-in user
    protected function role()
    {
        return optional(Auth::user())->type; // admin / scholar / student
    }

    // Is the given scholar (logged in) the owner of this student?
    protected function scholarOwns($student)
    {
        $scholar = Scholars::where('email', Auth::user()->email)->first();
        return $scholar && (int) $student->scholar === (int) $scholar->id;
    }

    // Can the logged-in user WRITE lessons for this student + lesson type?
    protected function canWrite($student, $type)
    {
        $role = $this->role();

        if ($role === 'admin') {
            return true;
        }

        $course = StudentCourse::where('user_id', $student->id)
            ->where('lesson_type', $type)
            ->where('is_active', 1)
            ->first();

        if (!$course) {
            return false;
        }

        if ($role === 'scholar') {
            return $this->scholarOwns($student) && $course->scholar_can_write;
        }

        if ($role === 'student') {
            return (int) Auth::id() === (int) $student->id && $course->student_can_write;
        }

        return false;
    }

    // Can the logged-in user even VIEW this student's lessons?
    protected function canView($student)
    {
        $role = $this->role();
        if ($role === 'admin') return true;
        if ($role === 'scholar') return $this->scholarOwns($student);
        if ($role === 'student') return (int) Auth::id() === (int) $student->id;
        return false;
    }

    // All dropdown options for a type, grouped by field_key
    protected function optionsFor($type)
    {
        return LessonOption::where('lesson_type', $type)
        ->get()
        ->groupBy('field_key')
        ->map(function ($group) {
            return $group->sort(function ($a, $b) {
                return $a->sort_order <=> $b->sort_order
                    ?: strnatcasecmp($a->label, $b->label);
            })->values();
        });
    }

    public function reorderOptions(Request $request)
    {
        $ids = (array) $request->input('ids', []);
        foreach ($ids as $index => $id) {
            LessonOption::where('id', $id)->update(['sort_order' => $index + 1]);
        }
        return response()->json(['success' => true, 'message' => 'Order saved!']);
    }

    /* =========================================================
     |  ADMIN: assign courses to a student (+ permissions)
     |=========================================================*/

    public function courses($id)
    {
        $student = User::where('type', 'student')->findOrFail($id);
        $courses = StudentCourse::where('user_id', $id)->orderBy('lesson_type')->get();

        return view('admin.lessons.courses', compact('student', 'courses'));
    }

    public function storeCourse(Request $request)
    {
        $request->validate([
            'user_id'     => 'required|exists:users,id',
            'lesson_type' => 'required|exists:lesson_types,key',
            'course_name' => 'required|string|max:255',
        ]);

        $course = StudentCourse::create([
            'user_id'           => $request->user_id,
            'lesson_type'       => $request->lesson_type,
            'course_name'       => $request->course_name,
            'scholar_can_write' => filter_var($request->input('scholar_can_write'), FILTER_VALIDATE_BOOLEAN),
            'student_can_write' => filter_var($request->input('student_can_write'), FILTER_VALIDATE_BOOLEAN),
            'is_active'         => true,
        ]);

        // Make the assigned course available in the "Course" dropdown too
        LessonOption::firstOrCreate([
            'lesson_type' => $request->lesson_type,
            'field_key'   => 'course',
            'label'       => $request->course_name,
        ]);

        return response()->json(['success' => true, 'message' => 'Course assigned!', 'course' => $course]);
    }

    public function updateCourse(Request $request)
    {
        $course = StudentCourse::findOrFail($request->id);
        $course->scholar_can_write = filter_var($request->input('scholar_can_write'), FILTER_VALIDATE_BOOLEAN);
        $course->student_can_write = filter_var($request->input('student_can_write'), FILTER_VALIDATE_BOOLEAN);
        $course->is_active         = filter_var($request->input('is_active'), FILTER_VALIDATE_BOOLEAN);
        $course->save();

        return response()->json(['success' => true, 'message' => 'Course updated!']);
    }

    public function deleteCourse(Request $request)
    {
        StudentCourse::where('id', $request->id)->delete();
        return response()->json(['success' => true, 'message' => 'Course removed!']);
    }

    /* =========================================================
     |  ADMIN: manage dropdown ("Add Item") options
     |=========================================================*/

    public function options(Request $request)
    {
        $types   = LessonType::types();                       // [key => label]
        $default = array_key_first($types) ?? 'quran';
        $type    = $request->input('type', $default);

        $fields  = LessonOption::fieldsFor($type);
        $options = $this->optionsFor($type);

        return view('admin.lessons.options', compact('type', 'fields', 'options'));
    }

    // Add an option. Works from the manage page AND inline ("+ Add" in a table).
    public function storeOption(Request $request)
    {
        $request->validate([
            'lesson_type' => 'required|exists:lesson_types,key',
            'field_key'   => 'required|string|max:50',
            'label'       => 'required|string|max:255',
        ]);

        $option = LessonOption::firstOrCreate([
            'lesson_type' => $request->lesson_type,
            'field_key'   => $request->field_key,
            'label'       => $request->label,
        ], [
            'sort_order'  => $request->filled('sort_order')
                ? (int) $request->input('sort_order')
                : ((int) LessonOption::where('lesson_type', $request->lesson_type)
                        ->where('field_key', $request->field_key)
                        ->max('sort_order') + 1),
        ]);

        return response()->json(['success' => true, 'message' => 'Item added!', 'option' => $option]);
    }

    public function deleteOption(Request $request)
    {
        LessonOption::where('id', $request->id)->delete();
        return response()->json(['success' => true, 'message' => 'Item deleted!']);
    }

    // AJAX: get options for a type grouped by field (used to refresh a table's dropdowns)
    public function getOptions($type)
    {
        return response()->json($this->optionsFor($type));
    }

    /* =========================================================
     |  ADMIN: manage LESSON TYPES (add your own types)
     |=========================================================*/

    public function lessonTypes()
    {
        $types = LessonType::orderBy('sort_order')->orderBy('label')->get();
        $pool  = LessonType::$pool;

        return view('admin.lessons.types', compact('types', 'pool'));
    }

    // Build a column config array from the posted columns[] data
    protected function buildColumns(Request $request)
    {
        $pool    = LessonType::$pool;
        $columns = [];
        $seen    = [];

        // Existing pool-based columns (admin ne tick kiye)
        foreach ((array) $request->input('columns', []) as $key => $data) {
            if (empty($data['enabled']) || !isset($pool[$key])) {
                continue;
            }
            $label = trim($data['label'] ?? '') ?: $pool[$key][0];
            $type  = $this->normalizeColType($data['type'] ?? '');
            $columns[]  = ['key' => $key, 'label' => $label, 'type' => $type];
            $seen[$key] = true;
        }

        foreach ((array) $request->input('custom_columns', []) as $data) {
            $label = trim($data['label'] ?? '');
            if ($label === '') {
                continue;
            }

            $base = \Illuminate\Support\Str::slug($label, '_') ?: 'col';
            $key  = $base;
            $j    = 1;
            while (isset($seen[$key]) || isset($pool[$key])) {
                $key = $base . '_' . (++$j);
            }

            $type = $this->normalizeColType($data['type'] ?? '');
            $columns[]  = ['key' => $key, 'label' => $label, 'type' => $type];
            $seen[$key] = true;
        }

        return $columns;
    }

    protected function normalizeColType($type)
    {
        $allowed = ['text', 'number', 'dropdown'];
        return in_array($type, $allowed, true) ? $type : 'text';
    }

    public function storeLessonType(Request $request)
    {
        $request->validate([
            'label' => 'required|string|max:100',
        ]);

        // key = slug of label (unique)
        $base = \Illuminate\Support\Str::slug($request->label, '_') ?: 'type';
        $key  = $base;
        $i    = 1;
        while (LessonType::where('key', $key)->exists()) {
            $key = $base . '_' . (++$i);
        }

        $columns = $this->buildColumns($request);
        if (empty($columns)) {
            return response()->json(['error' => 'Select at least one column for this type.'], 422);
        }

        $type = LessonType::create([
            'key'        => $key,
            'label'      => $request->label,
            'columns'    => $columns,
            'is_active'  => true,
            'sort_order' => (int) $request->input('sort_order', 0),
        ]);

        return response()->json(['success' => true, 'message' => 'Lesson type added!', 'type' => $type]);
    }

    public function updateLessonType(Request $request)
    {
        $type = LessonType::findOrFail($request->id);

        $type->label      = $request->input('label', $type->label);
        $type->is_active  = filter_var($request->input('is_active'), FILTER_VALIDATE_BOOLEAN);
        $type->sort_order = (int) $request->input('sort_order', $type->sort_order);

        // Columns are optional on update; only replace if any were submitted
        if ($request->has('columns')) {
            $columns = $this->buildColumns($request);
            if (!empty($columns)) {
                $type->columns = $columns;
            }
        }

        $type->save();

        return response()->json(['success' => true, 'message' => 'Lesson type updated!']);
    }

    public function deleteLessonType(Request $request)
    {
        $type = LessonType::findOrFail($request->id);

        // Block delete if any student is still enrolled in this type
        $inUse = StudentCourse::where('lesson_type', $type->key)->exists();
        if ($inUse) {
            return response()->json([
                'error' => 'This type is assigned to one or more students. Remove those courses first (or just turn it OFF).',
            ], 422);
        }

        $type->delete();

        return response()->json(['success' => true, 'message' => 'Lesson type deleted!']);
    }

    /* =========================================================
     |  LESSON ENTRY  (admin / scholar / student)
     |=========================================================*/

    // Entry page for a specific student (admin & scholar use this)
    public function entry($userId)
    {
        $student = User::where('type', 'student')->findOrFail($userId);
        abort_unless($this->canView($student), 403, 'You are not allowed to view this student.');

        return $this->renderEntry($student);
    }

    // Student's own lesson page
    public function myLessons()
    {
        $student = Auth::user();
        return $this->renderEntry($student);
    }

    // Shared render: builds a table for every lesson type the student is enrolled in
    protected function renderEntry($student)
    {
        $enrolled = StudentCourse::where('user_id', $student->id)
            ->where('is_active', 1)
            ->get()
            ->pluck('lesson_type')
            ->unique()
            ->values();

        $tables = [];
        foreach ($enrolled as $type) {
            $tables[$type] = [
                'columns'  => LessonRecord::columns($type),
                'options'  => $this->optionsFor($type),
                'records'  => LessonRecord::where('user_id', $student->id)
                                ->where('lesson_type', $type)
                                ->orderBy('id', 'asc')
                                ->get(),
                'can_write' => $this->canWrite($student, $type),
            ];
        }

        $typeLabels = StudentCourse::types();
        $scholarName = null;
        if (!empty($student->scholar)) {
            $scholarName = optional(Scholars::find($student->scholar))->name;
        }

        return view('admin.lessons.entry', compact('student', 'tables', 'typeLabels', 'scholarName'));
    }

    public function deleteRecord(Request $request)
    {
        $record  = LessonRecord::findOrFail($request->id);
        $student = User::findOrFail($record->user_id);

        if ($this->role() === 'student') {
            return response()->json(['error' => 'Students are not allowed to delete.'], 403);
        }
        if (!$this->canWrite($student, $record->lesson_type)) {
            return response()->json(['error' => 'You do not have permission.'], 403);
        }

        $record->delete();
        return response()->json(['success' => true, 'message' => 'Row deleted!']);
    }

    // Save all rows for one (student, type)
    // public function saveLessons(Request $request)
    // {
    //     $request->validate([
    //         'user_id'     => 'required|exists:users,id',
    //         'lesson_type' => 'required|exists:lesson_types,key',
    //     ]);

    //     $student = User::findOrFail($request->user_id);
    //     $type    = $request->lesson_type;

    //     if (!$this->canWrite($student, $type)) {
    //         return response()->json(['error' => 'You do not have permission to edit these lessons.'], 403);
    //     }

    //     $rows        = $request->input('rows', []);
    //     $allowedKeys = collect(LessonRecord::columns($type))->pluck('key')->toArray();

    //     $existing    = LessonRecord::where('user_id', $student->id)->where('lesson_type', $type)->pluck('id')->toArray();
    //     $keptIds     = [];

    //     foreach ($rows as $row) {
    //         $payload = [
    //             'user_id'      => $student->id,
    //             'lesson_type'  => $type,
    //             'created_by'   => Auth::id(),
    //             'creator_role' => $this->role(),
    //         ];

    //         foreach ($allowedKeys as $key) {
    //             $payload[$key] = $row[$key] ?? null;
    //         }

    //         // day auto-derived from date if a date is present and day is blank
    //         if (!empty($payload['lesson_date']) && empty($row['day'])) {
    //             try {
    //                 $payload['day'] = Carbon::parse($payload['lesson_date'])->format('l');
    //             } catch (\Exception $e) {}
    //         } elseif (!empty($row['day'])) {
    //             $payload['day'] = $row['day'];
    //         }

    //         if (!empty($row['id']) && in_array((int) $row['id'], $existing)) {
    //             LessonRecord::where('id', $row['id'])->update($payload);
    //             $keptIds[] = (int) $row['id'];
    //         } else {
    //             $new = LessonRecord::create($payload);
    //             $keptIds[] = $new->id;
    //         }
    //     }

    //     return response()->json(['success' => true, 'message' => ucfirst($type) . ' lessons saved!']);
    // }

    // Save all rows for one (student, type)
    public function saveLessons(Request $request)
    {
        $request->validate([
            'user_id'     => 'required|exists:users,id',
            'lesson_type' => 'required|exists:lesson_types,key',
        ]);

        $student = User::findOrFail($request->user_id);
        $type    = $request->lesson_type;

        if (!$this->canWrite($student, $type)) {
            return response()->json(['error' => 'You do not have permission to edit these lessons.'], 403);
        }

        $rows = $request->input('rows', []);

        // Is type ke saare columns (pool + custom)
        $allKeys = collect(LessonRecord::columns($type))->pluck('key')->toArray();

        // Sirf wahi keys jo lesson_records table mein REAL columns hain
        $tableColumns = \Illuminate\Support\Facades\Schema::getColumnListing((new LessonRecord)->getTable());
        $realKeys     = array_values(array_intersect($allKeys, $tableColumns));

        // Baqi keys = custom fields -> 'extra' JSON mein jaayengi
        $customKeys   = array_values(array_diff($allKeys, $tableColumns));

        $existing = LessonRecord::where('user_id', $student->id)->where('lesson_type', $type)->pluck('id')->toArray();
        $keptIds  = [];

        foreach ($rows as $row) {
            $payload = [
                'user_id'      => $student->id,
                'lesson_type'  => $type,
                'created_by'   => Auth::id(),
                'creator_role' => $this->role(),
            ];

            // 1) Real DB columns
            foreach ($realKeys as $key) {
                $payload[$key] = $row[$key] ?? null;
            }

            // 2) Custom fields -> extra JSON
            $extra = [];
            foreach ($customKeys as $key) {
                if (array_key_exists($key, $row)) {
                    $extra[$key] = $row[$key];
                }
            }
           if (in_array('extra', $tableColumns, true)) {
                $payload['extra'] = !empty($extra) ? json_encode($extra) : null;
            }

            if (!empty($payload['lesson_date']) && empty($row['day'])) {
                try {
                    $payload['day'] = Carbon::parse($payload['lesson_date'])->format('l');
                } catch (\Exception $e) {}
            } elseif (!empty($row['day'])) {
                $payload['day'] = $row['day'];
            }

            if (!empty($row['id']) && in_array((int) $row['id'], $existing)) {
                LessonRecord::where('id', $row['id'])->update($payload);
                $keptIds[] = (int) $row['id'];
            } else {
                $new = LessonRecord::create($payload);
                $keptIds[] = $new->id;
            }
        }

        return response()->json(['success' => true, 'message' => ucfirst($type) . ' lessons saved!']);
    }

    /* =========================================================
     |  REPORT  (admin / scholar) with filters
     |=========================================================*/

    // Group a flat record collection into [ type => ['columns'=>..,'records'=>..] ]
    // so each lesson type shows with ITS OWN columns (same as entry page).
    protected function groupByTypeWithColumns($records)
    {
        $grouped = [];
        foreach ($records->groupBy('lesson_type') as $type => $recs) {
            $grouped[$type] = [
                'columns' => LessonRecord::columns($type),
                'records' => $recs->values(),
            ];
        }
        return $grouped;
    }

    public function report(Request $request)
    {
        $user = Auth::user();

        // Scope which students are visible
        if ($user->type === 'admin') {
            $studentIds = User::where('type', 'student')->pluck('id');
        } elseif ($user->type === 'scholar') {
            $scholar = Scholars::where('email', $user->email)->first();
            $studentIds = $scholar
                ? User::where('scholar', $scholar->id)->where('type', 'student')->pluck('id')
                : collect();
        } else {
            $studentIds = collect([$user->id]);
        }

        $query = LessonRecord::whereIn('user_id', $studentIds)
            ->with('user')
            ->orderBy('lesson_date', 'desc')
            ->orderBy('id', 'desc');

        if ($request->filled('lesson_type')) $query->where('lesson_type', $request->lesson_type);
        if ($request->filled('student_id'))  $query->where('user_id', $request->student_id);
        if ($request->filled('year'))        $query->whereYear('lesson_date', $request->year);
        if ($request->filled('month'))       $query->whereMonth('lesson_date', $request->month);

        $records  = $query->get();
        $grouped  = $this->groupByTypeWithColumns($records);
        if ($request->filled('lesson_type') && !isset($grouped[$request->lesson_type])) {
            $grouped[$request->lesson_type] = [
                'columns' => LessonRecord::columns($request->lesson_type),
                'records' => collect(),
            ];
        }
        $students = User::whereIn('id', $studentIds)->select('id', 'name')->orderBy('name')->get();
        $typeLabels = StudentCourse::types();

        return view('admin.lessons.report', compact('grouped', 'records', 'students', 'typeLabels'));
    }

    /* =========================================================
     |  STUDENT: own report (read-only, same look as admin)
     |=========================================================*/

    public function myReport(Request $request)
    {
        $student = Auth::user();

        $query = LessonRecord::where('user_id', $student->id)
            ->with('user')
            ->orderBy('lesson_date', 'desc')
            ->orderBy('id', 'desc');

        if ($request->filled('lesson_type')) $query->where('lesson_type', $request->lesson_type);
        if ($request->filled('year'))        $query->whereYear('lesson_date', $request->year);
        if ($request->filled('month'))       $query->whereMonth('lesson_date', $request->month);

        $records = $query->get();
        $grouped = $this->groupByTypeWithColumns($records);
        if ($request->filled('lesson_type') && !isset($grouped[$request->lesson_type])) {
            $grouped[$request->lesson_type] = [
                'columns' => LessonRecord::columns($request->lesson_type),
                'records' => collect(),
            ];
        }
        // only the types this student is enrolled in (for the filter dropdown)
        $enrolledTypes = StudentCourse::where('user_id', $student->id)
            ->pluck('lesson_type')->unique()->values();
        $allLabels  = StudentCourse::types();
        $typeLabels = collect($allLabels)->only($enrolledTypes->all())->toArray();

        return view('admin.lessons.my_report', compact('grouped', 'records', 'student', 'typeLabels'));
    }

    /* =========================================================
     |  PDF  (admin / scholar / student-own)
     |=========================================================*/

    public function reportPdf(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'student_id' => 'required|exists:users,id',
        ]);

        $student = User::where('type', 'student')->findOrFail($request->student_id);

        // Permission: admin all, scholar own, student only self
        if ($user->type === 'scholar') {
            $scholar = Scholars::where('email', $user->email)->first();
            abort_unless($scholar && (int) $student->scholar === (int) $scholar->id, 403);
        } elseif ($user->type === 'student') {
            abort_unless((int) $user->id === (int) $student->id, 403);
        } elseif ($user->type !== 'admin') {
            abort(403);
        }

        $query = LessonRecord::where('user_id', $student->id)
            ->with('user')
            ->orderBy('lesson_date', 'asc')
            ->orderBy('id', 'asc');

        if ($request->filled('lesson_type')) $query->where('lesson_type', $request->lesson_type);
        if ($request->filled('year'))        $query->whereYear('lesson_date', $request->year);
        if ($request->filled('month'))       $query->whereMonth('lesson_date', $request->month);

        $records    = $query->get();
        $grouped    = $this->groupByTypeWithColumns($records);   // dynamic columns per type
        $typeLabels = StudentCourse::types();
        $info       = \App\Information::query()->first();
        $monthName  = $request->filled('month') ? (\App\FeeRecord::$months[(int) $request->month] ?? '') : '';
        $period     = trim($monthName . ' ' . $request->input('year', ''));
        if ($period === '') $period = 'All Records';

        // $pdf = \PDF::loadView('admin.lessons.report_pdf', compact(
        //     'grouped', 'records', 'student', 'typeLabels', 'period', 'request', 'info'
        // ))->setPaper('a4', 'landscape');

        // $fileName = 'lesson-report-' . \Illuminate\Support\Str::slug($student->name)
        //         . ($period !== 'All Records' ? '-' . \Illuminate\Support\Str::slug($period) : '')
        //         . '.pdf';

        // return $pdf->download($fileName);
        $fileName = 'lesson-report-' . \Illuminate\Support\Str::slug($student->name)
        . ($period !== 'All Records' ? '-' . \Illuminate\Support\Str::slug($period) : '')
        . '.pdf';

            $html = view('admin.lessons.report_pdf', compact(
                'grouped', 'records', 'student', 'typeLabels', 'period', 'request', 'info'
            ))->render();

            $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
            $fontDirs      = $defaultConfig['fontDir'];

            $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
            $fontData          = $defaultFontConfig['fontdata'];

            $mpdf = new \Mpdf\Mpdf([
                'mode'        => 'utf-8',
                'format'      => 'A4-L',
                'autoScriptToLang' => true,
                'autoLangToFont'   => true,
                'fontDir'     => array_merge($fontDirs, [storage_path('fonts')]),
                'fontdata'    => $fontData + [
                    'amiri' => [
                        'R' => 'Amiri-Regular.ttf',
                        'B' => 'Amiri-Bold.ttf',
                    ],
                ],
                'default_font' => 'amiri',
            ]);

            $mpdf->WriteHTML($html);

            return response($mpdf->Output($fileName, \Mpdf\Output\Destination::DOWNLOAD), 200, [
                'Content-Type' => 'application/pdf',
            ]);
    }
}