<?php

namespace App\Http\Controllers\Grades;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGradeRequest;
use App\Models\Classroom;
use App\Models\Grade;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $grades = Grade::all();    
        return view('pages.grades.grades', compact('grades'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGradeRequest $request)
    {
        // if (Grade::where('name -> ar', $request->name)->orWhere('name -> en', $request->name_en)->exists()) {
        //     return redirect()->back()->withErrors(trans('Grades_trans.exists'));
        // }
        try {
            // Retrieve the validated input data...
            $validated = $request->validated();
            // $grade = new Grade();
            // $grade->name = ['en' => $request['name_en'], 'ar' => $request['name']];
            // $grade->notes = $request['notes'];
            // $grade->save();
            Grade::create([
                'name' => ['en' => $request['name_en'], 'ar' => $request['name']],
                'notes' => $request['notes'],
            ]);
            toastr()->success(trans('messages.success'));
            return redirect()->route('grades.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Grade $grade) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Grade $grade)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreGradeRequest $request)
    {
        try {
            // Retrieve the validated input data...
            $validated = $request->validated();
            $grade = Grade::findOrFail($request->id);
            $grade->update([
                'name' => ['en' => $request['name_en'], 'ar' => $request['name']],
                'notes' => $request['notes'],
            ]);
            toastr()->success(trans('messages.Update'));
            return redirect()->route('grades.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try {
            if (Grade::find($request->id)->classrooms()->count() != 0) {
                return redirect()->route('grades.index')->withErrors(trans('Grades_trans.delete_Grade_Error'));
            }
            Grade::findOrFail($request->id)->delete();
            toastr()->error(trans('messages.Delete'));
            return redirect()->route('grades.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
