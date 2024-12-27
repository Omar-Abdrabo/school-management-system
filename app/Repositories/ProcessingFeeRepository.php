<?php

namespace App\Repositories;

use App\Models\Student;
use App\Models\ProcessingFee;
use App\Models\StudentAccountent;
use Illuminate\Support\Facades\DB;

class ProcessingFeeRepository implements ProcessingFeeRepositoryInterface
{

    public function index()
    {
        $processingFees = ProcessingFee::all();
        return view('pages.ProcessingFee.index', compact('processingFees'));
    }

    public function show($id)
    {
        $student = Student::findOrFail($id);
        // dd($student);
        return view('pages.ProcessingFee.add', compact('student'));
    }

    public function store($request)
    {
        // dd($request);
        DB::beginTransaction();

        try {

            $processingFee = new ProcessingFee();
            $processingFee->date = date('Y-m-d');
            $processingFee->student_id = $request->student_id;
            $processingFee->amount = $request->debit;
            $processingFee->description = $request->description;
            $processingFee->save();

            $studentAccountent = new StudentAccountent();
            $studentAccountent->date = date('Y-m-d');
            $studentAccountent->type = 'ProcessingFee';
            $studentAccountent->student_id = $request->student_id;
            $studentAccountent->processing_id = $processingFee->id;
            $studentAccountent->debit = 0.00;
            $studentAccountent->credit = $request->debit;
            $studentAccountent->description = $request->description;
            $studentAccountent->save();

            DB::commit();
            toastr()->success(trans('messages.success'));
            return redirect()->route('processing_fees.index');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $processingFee = ProcessingFee::findOrFail($id);
        return view('pages.ProcessingFee.edit', compact('processingFee'));
    }

    public function update($request)
    {
        // dd($request);
        DB::beginTransaction();
        try {
            $processingFee = ProcessingFee::findOrFail($request->id);
            $processingFee->date = date('Y-m-d');
            $processingFee->student_id = $request->student_id;
            $processingFee->amount = $request->debit;
            $processingFee->description = $request->description;
            $processingFee->save();

            $studentAccountent = StudentAccountent::where('processing_id', $request->id)->first();
            $studentAccountent->date = date('Y-m-d');
            $studentAccountent->type = 'ProcessingFee';
            $studentAccountent->student_id = $request->student_id;
            $studentAccountent->processing_id = $processingFee->id;
            $studentAccountent->debit = 0.00;
            $studentAccountent->credit = $request->debit;
            $studentAccountent->description = $request->description;
            $studentAccountent->save();

            DB::commit();
            toastr()->success(trans('messages.Update'));
            return redirect()->route('processing_fees.index');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroy($request)
    {
        try {
            ProcessingFee::destroy($request->id);
            toastr()->error(trans('messages.Delete'));
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
