<?php

namespace App\Repositories;

use App\Models\Student;
use App\Models\FundAccount;
use App\Models\StudentAccountent;
use App\Models\StudentReceipt;
use Illuminate\Support\Facades\DB;

class StudentReceiptRepository implements StudentReceiptRepositoryInterface
{
    public function index()
    {
        $student_receipts = StudentReceipt::all();
        return view('pages.Receipt.index', compact('student_receipts'));
    }

    public function show($id)
    {
        $student = Student::findOrFail($id);
        return view('pages.Receipt.add', compact('student'));
    }
    public function store($request)
    {
        // dd($request);
        DB::beginTransaction();
        try {

            $student_receipt = new StudentReceipt();
            $student_receipt->date = date('Y-m-d');
            $student_receipt->student_id = $request->student_id;
            $student_receipt->debit = $request->debit;
            $student_receipt->description = $request->description;
            $student_receipt->save();

            $fund_account = new FundAccount();
            $fund_account->date = date('Y-m-d');
            $fund_account->receipt_id = $student_receipt->id;
            $fund_account->debit = $request->debit;
            $fund_account->credit = 0.00;
            $fund_account->description = $request->description;
            $fund_account->save();

            $student_accountent = new StudentAccountent();
            $student_accountent->student_id = $request->student_id;
            $student_accountent->receipt_id = $student_receipt->id;
            $student_accountent->debit = 0.00;
            $student_accountent->credit = $request->debit;
            $student_accountent->description = $request->description;
            $student_accountent->date = date('Y-m-d');
            $student_accountent->type = 'receipt';
            $student_accountent->save();

            DB::commit();
            toastr()->success(trans('messages.success'));
            return redirect()->route('student_receipts.index');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $student_receipt = StudentReceipt::findOrFail($id);
        return view('pages.Receipt.edit', compact('student_receipt'));
    }

    public function update($request)
    {
        DB::beginTransaction();
        try {

            // dd($request);
            $student_receipt = StudentReceipt::findOrFail($request->id);
            // dd($student_receipt);
            $student_receipt->date = date('Y-m-d');
            $student_receipt->student_id = $request->student_id;
            $student_receipt->debit = $request->debit;
            $student_receipt->description = $request->description;
            $student_receipt->save();

            $fund_account = FundAccount::where('receipt_id', $request->id)->first();
            // dd($fund_account);
            $fund_account->date = date('Y-m-d');
            $fund_account->receipt_id = $student_receipt->id;
            $fund_account->debit = $request->debit;
            $fund_account->credit = 0.00;
            $fund_account->description = $request->description;
            $fund_account->save();

            $student_accountent = StudentAccountent::where('receipt_id', $request->id)->first();
            // dd($student_accountent);
            $student_accountent->student_id = $request->student_id;
            $student_accountent->receipt_id = $student_receipt->id;
            $student_accountent->debit = 0.00;
            $student_accountent->credit = $request->debit;
            $student_accountent->type = 'receipt';
            $student_accountent->date = date('Y-m-d');
            $student_accountent->description = $request->description;
            $student_accountent->save();

            DB::commit();
            toastr()->success(trans('messages.Update'));
            return redirect()->route('student_receipts.index');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroy($request) 
    {
        try {
            StudentReceipt::destroy($request->id);
            toastr()->error(trans('messages.Delete'));
            return redirect()->route('student_receipts.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
