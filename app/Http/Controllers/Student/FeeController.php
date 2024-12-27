<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFeeRequest;
use App\Models\Fee;
use App\Repositories\FeeRepositoryInterface;
use Illuminate\Http\Request;

class FeeController extends Controller
{

    /**
     * Constructs a new instance of the FeeController class, injecting the FeeRepositoryInterface implementation.
     *
     * @param FeeRepositoryInterface $feeRepo The FeeRepositoryInterface implementation to be used by this controller.
     */
    public function __construct(protected FeeRepositoryInterface $feeRepo) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->feeRepo->index();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->feeRepo->create();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFeeRequest $request)
    {
        return $this->feeRepo->store($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(Fee $fee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return $this->feeRepo->edit($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreFeeRequest $request)
    {
        return $this->feeRepo->update($request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        return $this->feeRepo->destroy($request);
    }
}
