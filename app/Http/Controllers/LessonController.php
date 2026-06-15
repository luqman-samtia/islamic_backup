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
            ->orderBy('sort_order')->orderBy('label')
            ->get()
            ->groupBy('field_key');
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
            'sort_order'  => (int) $request->input('sort_order', 0),
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

        foreach ((array) $request->input('columns', []) as $key => $data) {
            // only keep columns the admin actually ticked
            if (empty($data['enabled']) || !isset($pool[$key])) {
                continue;
            }
            $label = trim($data['label'] ?? '') ?: $pool[$key][0];
            $type  = ($data['type'] ?? '') === 'dropdown' ? 'dropdown' : 'text';
            // attendance & notes look best as dropdowns, but admin's choice wins
            $columns[] = ['key' => $key, 'label' => $label, 'type' => $type];
        }

        return $columns;
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
        $type->is_active  = $request->boolean('is_active');
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
                                ->orderBy('lesson_date', 'desc')
                                ->orderBy('id', 'desc')
                                ->get(),
                'can_write' => $this->canWrite($student, $type),
            ];
        }

        $typeLabels = StudentCourse::types();

        return view('admin.lessons.entry', compact('student', 'tables', 'typeLabels'));
    }

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

        $rows        = $request->input('rows', []);
        $allowedKeys = collect(LessonRecord::columns($type))->pluck('key')->toArray();

        $existing    = LessonRecord::where('user_id', $student->id)->where('lesson_type', $type)->pluck('id')->toArray();
        $keptIds     = [];

        foreach ($rows as $row) {
            $payload = [
                'user_id'      => $student->id,
                'lesson_type'  => $type,
                'created_by'   => Auth::id(),
                'creator_role' => $this->role(),
            ];

            foreach ($allowedKeys as $key) {
                $payload[$key] = $row[$key] ?? null;
            }

            // day auto-derived from date if a date is present and day is blank
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

        // Delete rows that were removed in the UI
        LessonRecord::where('user_id', $student->id)
            ->where('lesson_type', $type)
            ->whereNotIn('id', $keptIds)
            ->delete();

        return response()->json(['success' => true, 'message' => ucfirst($type) . ' lessons saved!']);
    }

    /* =========================================================
     |  REPORT  (admin / scholar) with filters
     |=========================================================*/

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
        $students = User::whereIn('id', $studentIds)->select('id', 'name')->orderBy('name')->get();

        return view('admin.lessons.report', compact('records', 'students'));
    }
}
