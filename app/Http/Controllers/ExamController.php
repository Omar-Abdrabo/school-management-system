<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Http\Requests\StoreExamRequest;
use App\Http\Requests\UpdateExamRequest;
use App\Repositories\ExamRepositoryInterface;
use Illuminate\Http\Request;

class ExamController extends Controller
{

    public function __construct(protected ExamRepositoryInterface $examRepo) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->examRepo->index();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->examRepo->create();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreExamRequest $request)
    {
        return $this->examRepo->store($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(Exam $exam)
    {
        // return $this->examRepo->show($exam);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return $this->examRepo->edit($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateExamRequest $request)
    {
        return $this->examRepo->update($request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        return $this->examRepo->destroy($request);
    }
}
