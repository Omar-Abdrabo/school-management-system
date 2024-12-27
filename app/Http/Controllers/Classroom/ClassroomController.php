<?php

namespace App\Http\Controllers\Classroom;

use App\Models\Grade;
use App\Models\Classroom;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreClassroomRequest;
use App\Http\Requests\UpdateClassroomRequest;

class ClassroomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $myClasses = Classroom::all();
        $grades = Grade::all();
        return view('pages.classrooms.classrooms', compact('myClasses', 'grades'));
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
    public function store(StoreClassroomRequest $request)
    {
        $list_classes = $request->list_classes;
        try {
            $validated = $request->validated();
            foreach ($list_classes as $list_class) {
                $classes = new Classroom();
                $classes->name_class = ['en' => $list_class['name_class_en'], 'ar' => $list_class['name']];
                $classes->grade_id = $list_class['grade_id'];
                $classes->save();
            }
            toastr()->success(trans('messages.success'));
            return redirect()->route('classrooms.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Classroom $classroom)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Classroom $classroom)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreClassroomRequest $request)
    {
        try {
            $validated = $request->validated();
            $classes = Classroom::findOrFail($request->id);
            $classes->update([
                $classes->name_class = ['en' => $request->name_class_en, 'ar' => $request->name],
                $classes->grade_id = $request->grade_id,
            ]);
            toastr()->success(trans('messages.Update'));
            return redirect()->route('classrooms.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        Classroom::findOrFail($request->id)->delete();
        return redirect()->route('classrooms.index');
    }

    public function delete_selected(Request $request)
    {
        $delete_all_selected = explode(",", $request->delete_all_selected);
        Classroom::whereIn('id', $delete_all_selected)->Delete();
        // Classroom::destroy($delete_all_selected);
        toastr()->error(trans('messages.Delete'));
        return redirect()->route('classrooms.index');
    }

    public function filter(Request $request)
    {
        // $grades = Grade::all();
        // $search = Classroom::select('*')->where('grade_id', '=', $request->grade_id)->get();
        // return view('pages.classrooms.classrooms', compact('grades'))->with('search',$search);
        $grades = Grade::all();
        $search = Grade::find($request->grade_id)->classrooms;
        return view('pages.classrooms.classrooms', compact('grades'))->with('search', $search);
    }
}
