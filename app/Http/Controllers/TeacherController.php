<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTeacherRequest;
use App\Http\Requests\UpdateTeacherRequest;
use App\Repositories\TeacherRepositoryInterface;

class TeacherController extends Controller
{

    public function __construct(private TeacherRepositoryInterface $teacherRepo) {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teachers = $this->teacherRepo->getAllTeachers();
        return view('pages.Teachers.Teachers', compact('teachers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $specializations = $this->teacherRepo->getSpecialization();
        $genders = $this->teacherRepo->getGender();
        return view('pages.Teachers.create', compact('specializations', 'genders'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTeacherRequest $request)
    {
        return $this->teacherRepo->storeTeacher($request);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Teacher $teacher)
    {
        $teacher = $this->teacherRepo->editTeacher($teacher->id);
        $specializations = $this->teacherRepo->getSpecialization();
        $genders = $this->teacherRepo->getGender();
        return view('pages.Teachers.edit', compact('teacher', 'specializations', 'genders'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTeacherRequest $request)
    {
        return $this->teacherRepo->updateTeacher($request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        return $this->teacherRepo->deleteTeacher($request->id);
    }

}
