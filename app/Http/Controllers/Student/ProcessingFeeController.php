<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\ProcessingFeeRepositoryInterface;

class ProcessingFeeController extends Controller
{

    public function __construct(protected ProcessingFeeRepositoryInterface $processingFeeRepo) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->processingFeeRepo->index();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return $this->processingFeeRepo->store($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return $this->processingFeeRepo->show($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return $this->processingFeeRepo->edit($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        return $this->processingFeeRepo->update($request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        return $this->processingFeeRepo->destroy($request);
    }
}
