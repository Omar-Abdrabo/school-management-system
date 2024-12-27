<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Repositories\GraduatedStudentRepositoryInterface;
use Illuminate\Http\Request;

class GraduatedStudentController extends Controller
{

    public function __construct(protected GraduatedStudentRepositoryInterface $graduatedStudentRepo) {}


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->graduatedStudentRepo->index();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->graduatedStudentRepo->create();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return $this->graduatedStudentRepo->softDelete($request);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        return $this->graduatedStudentRepo->returnStudent($request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        return $this->graduatedStudentRepo->deleteForEver($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }
    
}
