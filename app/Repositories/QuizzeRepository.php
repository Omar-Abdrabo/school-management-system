<?php

namespace App\Repositories;

use App\Models\Grade;
use App\Models\Quizze;
use App\Models\Subject;
use App\Models\Teacher;

class QuizzeRepository implements QuizzeRepositoryInterface
{
    public function index()
    {
        $quizzes = Quizze::all();
        return view('pages.quizzes.index', compact('quizzes'));
    }

    public function create()
    {
        $grades = Grade::all();
        $subjects = Subject::all();
        $teachers = Teacher::all();
        return view('pages.quizzes.create', compact('grades', 'subjects', 'teachers'));
    }

    public function store($request)
    {
        // dd($request);
        try {
            Quizze::create([
                'name' => ['en' => $request->name_en, 'ar' => $request->name_ar],
                'subject_id' => $request->subject_id,
                'teacher_id' => $request->teacher_id,
                'grade_id' => $request->grade_id,
                'classroom_id' => $request->classroom_id,
                'section_id' => $request->section_id,
            ]);
            toastr()->success(trans('messages.success'));
            return redirect()->route('quizzes.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $quizze = Quizze::findorFail($id);
        $grades = Grade::all();
        $subjects = Subject::all();
        $teachers = Teacher::all();
        return view('pages.quizzes.edit', compact('quizze', 'grades', 'subjects', 'teachers'));
    }

    public function update($request)
    {
        // dd($request);
        try {
            $quizze = Quizze::findorFail($request->id);
            $quizze->update([
                'name' => ['en' => $request->name_en, 'ar' => $request->name_ar],
                'subject_id' => $request->subject_id,
                'teacher_id' => $request->teacher_id,
                'grade_id' => $request->grade_id,
                'classroom_id' => $request->classroom_id,
                'section_id' => $request->section_id,
            ]);
            toastr()->success(trans('messages.Update'));
            return redirect()->route('quizzes.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroy($request)
    {
        // dd($request);
        try {
            Quizze::destroy($request->id);
            toastr()->error(trans('messages.Delete'));
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
