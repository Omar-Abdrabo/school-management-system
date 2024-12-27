<?php

namespace App\Repositories;

use App\Models\Grade;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\StudentAttendance;

class StudentAttendanceRepository implements StudentAttendanceRepositoryInterface
{
    public function index()
    {
        $grades = Grade::with(['sections'])->get();
        $list_grades = Grade::all();
        $teachers = Teacher::all();

        return view('pages.Attendance.Sections', compact('grades', 'list_grades', 'teachers'));
    }

    public function show($id)
    {
        $students = Student::with('studentAttendance')->where('section_id', $id)->get();
        return view('pages.Attendance.index', compact('students'));
    }

    public function store($request)
    {
        // dd($request->all());
        try {
            foreach ($request->attendances as $student_id => $studentAttendance) {
                if ($studentAttendance == 'presence') {
                    $attendence_status = true;
                } else if ($studentAttendance == 'absent') {
                    $attendence_status = false;
                }

                StudentAttendance::create([
                    'student_id' => $student_id,
                    'grade_id' => $request->grade_id,
                    'classroom_id' => $request->classroom_id,
                    'section_id' => $request->section_id,
                    'teacher_id' => 1,
                    'attendance_date' => date('Y-m-d'),
                    'attendance_status' => $attendence_status
                ]);
            }

            toastr()->success(trans('messages.success'));
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function update($request) {}

    public function destroy($request) {}
}
