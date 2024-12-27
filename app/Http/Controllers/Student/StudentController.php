<?php

namespace App\Http\Controllers\Student;

use App\Models\Student;
use App\Models\Classroom;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Repositories\StudentRepositoryInterface;

class StudentController extends Controller
{

    public function __construct(protected StudentRepositoryInterface $studentRepo) {}


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $students = $this->studentRepo->getAllStudents();
        return view('pages.students.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->studentRepo->createStudent();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStudentRequest $request)
    {
        // dd($request->photos);
        return $this->studentRepo->storeStudent($request);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return $this->studentRepo->showStudent($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        return $this->studentRepo->editStudent($student);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStudentRequest $request)
    {
        return $this->studentRepo->updateStudent($request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        return $this->studentRepo->deleteStudent($student);
    }

    public function getClassrooms($id)
    {
        return $this->studentRepo->getClassrooms($id);
    }

    public function getSections($id)
    {
        return $this->studentRepo->getSections($id);
    }

    public function upload_attachment(Request $request)
    {
        return $this->studentRepo->upload_attachment($request);
    }

    public function download_attachment($student_name, $file_name)
    {
        return $this->studentRepo->download_attachment($student_name, $file_name);
    }

    public function delete_attachment(Request $request)
    {
        return $this->studentRepo->delete_attachment($request);
    }
}
