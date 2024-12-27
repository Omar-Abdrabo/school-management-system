<?php

namespace App\Http\Controllers\Sections;

use App\Models\Grade;
use App\Models\Section;
use App\Models\Teacher;
use App\Models\Classroom;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $grades = Grade::all();
        // $classrooms = Classroom::all();
        // $sections = Section::all();
        // return view('pages.Sections.Sections', compact('sections', 'grades', 'classrooms'));
        // dd($grades[0]->sections[0]->classroom);
        $teachers = Teacher::all();
        $grades = Grade::with(['sections'])->get();
        return view('pages.Sections.Sections', compact('grades', 'teachers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // echo "<pree>";
        // var_dump($request->all());
        try {
            $validated = $request->validate(
                [
                    'section_name_ar' => 'required',
                    'section_name_en' => 'required',
                    'grade_id' => 'required',
                    'class_id' => 'required',
                ],
                [
                    'section_name_ar.required' => trans('Sections_trans.required_ar'),
                    'section_name_en.required' => trans('Sections_trans.required_en'),
                    'grade_id.required' => trans('Sections_trans.Grade_id_required'),
                    'class_id.required' => trans('Sections_trans.Class_id_required'),
                ]
            );

            Section::create([
                'section_name' => ['en' => $request['section_name_en'], 'ar' => $request['section_name_ar']],
                'grade_id' => $request->grade_id,
                'classroom_id' => $request->class_id,
            ])->teachers()->attach($request->teacher_id);

            toastr()->success(trans('messages.success'));
            // return redirect()->back();
            return redirect()->route('sections.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            $validated = $request->validate(
                [
                    'section_name_ar' => 'required',
                    'section_name_en' => 'required',
                    'grade_id' => 'required',
                    'class_id' => 'required',
                    // 'status' => 'required',
                ],
                [
                    'section_name_ar.required' => trans('Sections_trans.required_ar'),
                    'section_name_en.required' => trans('Sections_trans.required_en'),
                    'grade_id.required' => trans('Sections_trans.Grade_id_required'),
                    'class_id.required' => trans('Sections_trans.Class_id_required'),

                ]
            );
            $section = Section::findOrFail($request->id);
            $section->update([
                'section_name' => ['en' => $request['section_name_en'], 'ar' => $request['section_name_ar']],
                'grade_id' => $request->grade_id,
                'classroom_id' => $request->class_id,
                'status' => $request->status === 'on' ? 1 : 0,
            ]);

            // Synchronizes the teachers associated with the section.
            $section->teachers()->sync($request->teacher_id);
            toastr()->success(trans('messages.Update'));
            return redirect()->route('sections.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Retrieves a list of classrooms for a given grade ID.
     *
     * @param int $id The ID of the grade.
     * @return \Illuminate\Support\Collection A collection of classroom names and IDs.
     */

    public function getClassrooms($id)
    {
        $list_classes = Classroom::where("grade_id", $id)->pluck("name_class", "id");
        // echo "<pre>";
        // var_dump($list_classes);
        return $list_classes;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try {
            Section::findOrFail($request->id)->delete();
            toastr()->error(trans('messages.Delete'));
            return   redirect()->route('sections.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
        // dd($request);
    }
}
