<?php

namespace App\Repositories;

use App\Models\FundAccount;
use App\Models\Student;
use App\Models\PaymentStudent;
use App\Models\StudentAccountent;
use Illuminate\Support\Facades\DB;

class PaymentStudentRepository implements PaymentStudentRepositoryInterface
{

    public function index()
    {
        $payment_students = PaymentStudent::all();
        return view('pages.Payment.index', compact('payment_students'));
    }

    public function show($id)
    {
        $student = Student::findOrFail($id);
        return view('pages.Payment.add', compact('student'));
    }

    public function store($request)
    {
        // dd($request);
        DB::beginTransaction();
        try {

            $paymentStudent = new PaymentStudent();
            $paymentStudent->date = date('Y-m-d');
            $paymentStudent->student_id = $request->student_id;
            $paymentStudent->amount = $request->debit;
            $paymentStudent->description = $request->description;
            $paymentStudent->save();

            $fundAccount = new FundAccount();
            $fundAccount->date = date('Y-m-d');
            $fundAccount->payment_id = $paymentStudent->id;
            $fundAccount->debit = 0.00;
            $fundAccount->credit = $request->debit;
            $fundAccount->description = $request->description;
            $fundAccount->save();

            $studentAccountent = new StudentAccountent();
            $studentAccountent->date = date('Y-m-d');
            $studentAccountent->type = 'payment';
            $studentAccountent->student_id = $request->student_id;
            $studentAccountent->payment_id = $paymentStudent->id;
            $studentAccountent->debit = $request->debit;
            $studentAccountent->credit = 0.00;
            $studentAccountent->description = $request->description;
            $studentAccountent->save();

            DB::commit();
            return redirect()->route('payment_students.index');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $payment_student = PaymentStudent::findOrFail($id);
        return view('pages.Payment.edit', compact('payment_student'));
    }

    public function update($request)
    {
        // dd($request);

        DB::beginTransaction();
        try {
            $paymentStudent = PaymentStudent::findOrFail($request->id);
            $paymentStudent->date = date('Y-m-d');
            $paymentStudent->student_id = $request->student_id;
            $paymentStudent->amount = $request->debit;
            $paymentStudent->description = $request->description;
            $paymentStudent->save();

            $fundAccount = FundAccount::where('payment_id', $paymentStudent->id)->first();
            $fundAccount->date = date('Y-m-d');
            $fundAccount->payment_id = $paymentStudent->id;
            $fundAccount->debit = 0.00;
            $fundAccount->credit = $request->debit;
            $fundAccount->description = $request->description;
            $fundAccount->save();

            $studentAccountent = StudentAccountent::where('payment_id', $paymentStudent->id)->first();
            $studentAccountent->date = date('Y-m-d');
            $studentAccountent->type = 'payment';
            $studentAccountent->student_id = $request->student_id;
            $studentAccountent->payment_id = $paymentStudent->id;
            $studentAccountent->debit = $request->debit;
            $studentAccountent->credit = 0.00;
            $studentAccountent->description = $request->description;
            $studentAccountent->save();

            DB::commit();
            return redirect()->route('payment_students.index');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroy($request)
    {
        try {
            PaymentStudent::destroy($request->id);
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
