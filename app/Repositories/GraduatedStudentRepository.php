<?php

namespace App\Repositories;

use App\Models\Grade;
use App\Models\Student;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class GraduatedStudentRepository implements GraduatedStudentRepositoryInterface
{

    public function index()
    {
        $students = Student::onlyTrashed()->get();
        return view('pages.Students.Graduated.index', compact('students'));
    }

    public function create()
    {
        $grades = Grade::all();
        return view('pages.Students.Graduated.create', compact('grades'));
    }

    // GRDUATE STUDENT USING SOFT DELETE
    public function softDelete($request)
    {
        $students = Student::where('grade_id', $request->grade_id)->where('classroom_id', $request->classroom_id)->where('section_id', $request->section_id)->get();
        if ($students->count() < 1) {
            return redirect()->back()->with('error_Graduated', __('لاتوجد بيانات في جدول الطلاب'));
        }
        // $ids = $students->pluck('id')->toArray();
        foreach ($students as $student) {
            $student->delete();
        }
        toastr()->success(trans('messages.success'));
        return redirect()->route('graduated.index');
    }

    public function returnStudent($request)
    {
        Student::onlyTrashed()->where('id', $request->id)->restore();
        toastr()->success(trans('messages.success'));
        return redirect()->route('graduated.index');
    }

    public function deleteForEver($request)
    {
        DB::beginTransaction();
        try {
            $student =  Student::withTrashed()->where('id', $request->id)->get();
            // dd($student[0]->attachments()->count());
            // dd($student->id);
            if ($student[0]->attachments->count() > 0) {
                Storage::disk('upload_attachments')->deleteDirectory('attachments/student_attachment/' . $student[0]->id);
                $student[0]->attachments()->delete();
            }
            Student::onlyTrashed()->where('id', $request->id)->forceDelete();
            DB::commit();
            toastr()->error(trans('messages.Delete'));
            return redirect()->route('graduated.index');
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
