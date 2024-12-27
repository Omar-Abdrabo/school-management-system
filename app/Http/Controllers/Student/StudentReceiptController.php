<?php

namespace App\Http\Controllers\Student;


use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStudentReceiptRequest;
use App\Http\Requests\UpdateStudentReceiptRequest;
use App\Repositories\StudentReceiptRepositoryInterface;
use Illuminate\Http\Request;

class StudentReceiptController extends Controller
{

    public function __construct(protected StudentReceiptRepositoryInterface $studentReceiptRepo) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->studentReceiptRepo->index();
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
    public function store(StoreStudentReceiptRequest $request)
    {
        return $this->studentReceiptRepo->store($request);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return $this->studentReceiptRepo->show($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return $this->studentReceiptRepo->edit($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStudentReceiptRequest $request,)
    {
        return $this->studentReceiptRepo->update($request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        // dd($request);
        return $this->studentReceiptRepo->destroy($request);
    }
}
