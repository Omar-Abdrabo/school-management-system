<?php

namespace App\Http\Controllers\Student;

use App\Models\FeeInvoice;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFeeInvoicesRequest;
use App\Http\Requests\UpdateFeeInvoicesRequest;
use App\Repositories\FeeInvoicesRepositoryInterface;


class FeeInvoiceController extends Controller
{

    public function __construct(protected FeeInvoicesRepositoryInterface $feeInvoicesRepo) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->feeInvoicesRepo->index();
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
    public function store(StoreFeeInvoicesRequest $request)
    {
        return $this->feeInvoicesRepo->store($request);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return $this->feeInvoicesRepo->show($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( $id)
    {
        return $this->feeInvoicesRepo->edit($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFeeInvoicesRequest $request)
    {
        return $this->feeInvoicesRepo->update($request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        return $this->feeInvoicesRepo->destroy($request);
    }
}
