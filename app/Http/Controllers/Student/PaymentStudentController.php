<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePaymentStudentRequest;
use App\Http\Requests\UpdatePaymentStudentRequest;
use App\Repositories\PaymentStudentRepositoryInterface;
use Illuminate\Http\Request;

class PaymentStudentController extends Controller
{

    public function __construct(protected PaymentStudentRepositoryInterface $paymentStudentRepo) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->paymentStudentRepo->index();
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
    public function store(StorePaymentStudentRequest $request)
    {
        return $this->paymentStudentRepo->store($request);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return $this->paymentStudentRepo->show($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return $this->paymentStudentRepo->edit($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePaymentStudentRequest $request)
    {
        return $this->paymentStudentRepo->update($request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        return $this->paymentStudentRepo->destroy($request);
    }
}
