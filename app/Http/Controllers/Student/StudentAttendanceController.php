<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;
use App\Models\StudentAttendance;
use App\Http\Controllers\Controller;
use App\Repositories\StudentAttendanceRepositoryInterface;

class StudentAttendanceController extends Controller
{

    public function __construct(protected StudentAttendanceRepositoryInterface $studentAttendanceRepo) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->studentAttendanceRepo->index();
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
    public function store(Request $request)
    {
        return $this->studentAttendanceRepo->store($request);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return $this->studentAttendanceRepo->show($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StudentAttendance $studentAttendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StudentAttendance $studentAttendance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StudentAttendance $studentAttendance)
    {
        //
    }
}
