<?php

namespace App\Repositories;

use App\Models\Fee;
use App\Models\Grade;
use App\Models\Student;
use App\Models\FeeInvoice;
use App\Models\StudentAccountent;
use Illuminate\Support\Facades\DB;

class FeeInvoicesRepository implements FeeInvoicesRepositoryInterface
{
    public function index()
    {
        $fee_invoices = FeeInvoice::all();
        $grades = Grade::all();
        return view('pages.Fees_Invoices.index', compact('fee_invoices', 'grades'));
    }

    public function show($id)
    {
        $student = Student::findOrFail($id);
        $fees = Fee::where('grade_id', $student->grade_id)->where('classroom_id', $student->classroom_id)->get();
        // dd($fees);
        return view('pages.Fees_Invoices.add', compact('student', 'fees'));
    }

    public function store($request)
    {
        $list_fees =  $request->list_fees;

        DB::beginTransaction();
        try {
            foreach ($list_fees as $list_fee) {
                $fee_invoice = new FeeInvoice();
                $fee_invoice->invoice_date = date('Y-m-d');
                $fee_invoice->student_id = $list_fee['student_id'];
                $fee_invoice->fee_id = $list_fee['fee_id'];
                $fee_invoice->amount = $list_fee['amount'];
                $fee_invoice->description = $list_fee['description'];
                $fee_invoice->grade_id = $request->grade_id;
                $fee_invoice->classroom_id = $request->classroom_id;
                $fee_invoice->save();

                $studentAccountent = new StudentAccountent();
                $studentAccountent->student_id = $list_fee['student_id'];
                $studentAccountent->fee_invoice_id = $fee_invoice->id;
                $studentAccountent->debit = $list_fee['amount'];
                $studentAccountent->credit = 0.00;
                $studentAccountent->description = $list_fee['description'];
                $studentAccountent->type = 'invoice';
                $studentAccountent->date = date('Y-m-d');
                $studentAccountent->save();
            }
            DB::commit();
            toastr()->success(trans('messages.success'));
            return redirect()->route('fee_invoices.index');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $fee_invoice = FeeInvoice::findOrFail($id);
        $fees = Fee::where('grade_id', $fee_invoice->grade_id)->where('classroom_id', $fee_invoice->classroom_id)->get();
        return view('pages.Fees_Invoices.edit', compact('fee_invoice', 'fees'));
    }

    public function update($request)
    {
        // dd($request);
        DB::beginTransaction();
        try {
            $fee_invoice = FeeInvoice::findOrFail($request->id);
            $fee_invoice->fee_id = $request->fee_id;
            $fee_invoice->amount = $request->amount;
            $fee_invoice->description = $request->description;
            $fee_invoice->save();

            $studentAccountent = StudentAccountent::where('fee_invoice_id', $request->id)->first();
            $studentAccountent->debit = $request->amount;
            $studentAccountent->description = $request->description;
            $studentAccountent->save();
            DB::commit();
            toastr()->success(trans('messages.Update'));
            return redirect()->route('fee_invoices.index');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroy($request)
    {
        try {
            FeeInvoice::destroy($request->id);
            toastr()->error(trans('messages.Delete'));
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
