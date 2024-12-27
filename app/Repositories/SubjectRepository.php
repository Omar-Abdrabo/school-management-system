<?php

namespace App\Repositories;

use App\Models\Grade;
use App\Models\Subject;
use App\Models\Teacher;

class SubjectRepository implements SubjectRepositoryInterface
{
    public function index()
    {
        $subjects = Subject::all();
        return view('pages.subjects.index', compact('subjects'));
    }

    public function create()
    {
        $grades = Grade::all();
        $teachers = Teacher::all();
        return view('pages.subjects.create', compact('grades', 'teachers'));
    }

    public function store($request)
    {
        // dd($request);
        try {

            Subject::create([
                'name' => ['en' => $request->name_en, 'ar' => $request->name_ar],
                'grade_id' => $request->grade_id,
                'classroom_id' => $request->classroom_id,
                'teacher_id' => $request->teacher_id,
            ]);

            toastr()->success(trans('messages.success'));
            return redirect()->route('subjects.index');
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $subject = Subject::findorfail($id);
        $grades = Grade::all();
        $teachers = Teacher::all();
        return view('pages.subjects.edit', compact('subject', 'grades', 'teachers'));
    }

    public function update($request)
    {
        // dd($request);
        try {
            $subject = Subject::findorfail($request->id);
            $subject->update([
                'name' => ['en' => $request->name_en, 'ar' => $request->name_ar],
                'grade_id' => $request->grade_id,
                'classroom_id' => $request->classroom_id,
                'teacher_id' => $request->teacher_id,
            ]);

            toastr()->success(trans('messages.Update'));
            return redirect()->route('subjects.index');
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function destroy($request)
    {
        Subject::destroy($request->id);
        toastr()->error(trans('messages.Delete'));
        return redirect()->back();
    }
}
