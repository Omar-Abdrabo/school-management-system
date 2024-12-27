<?php

namespace App\Repositories;

use App\Models\Exam;

class ExamRepository implements ExamRepositoryInterface
{
    public function index()
    {
        $exams = Exam::all();
        return view('pages.Exams.index', compact('exams'));
    }

    public function create()
    {
        return view('pages.Exams.create');
    }

    public function store($request)
    {
        try {

            Exam::create([
                'name' =>  ['en' => $request->name_en, 'ar' => $request->name_ar],
                'term' => $request->term,
                'academic_year' => $request->academic_year,
            ]);

            toastr()->success(trans('messages.success'));
            return redirect()->route('exams.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $exam = Exam::findOrFail($id);
        return view('pages.Exams.edit', compact('exam'));
    }

    public function update($request)
    {
        try {
            Exam::findOrFail($request->id)->update([
                'name' =>  ['en' => $request->name_en, 'ar' => $request->name_ar],
                'term' => $request->term,
                'academic_year' => $request->academic_year,
            ]);
            toastr()->success(trans('messages.Update'));
            return redirect()->route('exams.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroy($request)
    {
        try {
            Exam::destroy($request->id);
            toastr()->error(trans('messages.Delete'));
            return redirect()->route('exams.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
