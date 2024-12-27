<?php

namespace App\Repositories;

use App\Models\Fee;
use App\Models\Grade;

class FeeRepository implements FeeRepositoryInterface
{

    public function index()
    {
        // $grades = Grade::all();, 'grades'
        $fees = Fee::all();
        return view('pages.Fees.index', compact('fees'));
    }

    public function create()
    {
        $grades = Grade::all();
        return view('pages.Fees.add', compact('grades'));
    }

    public function store($request)
    {
        if (Fee::where('grade_id', $request->grade_id)->where('classroom_id', $request->classroom_id)->where('year', $request->year)->where('fee_type', $request->fee_type)->exists()) {
            return redirect()->back()->withErrors(['error' => 'This grade already has a fee']);
        }

        try {
            Fee::create([
                'title' => ['ar' => $request->title_ar, 'en' => $request->title_en],
                'amount' => $request->amount,
                'grade_id' => $request->grade_id,
                'classroom_id' => $request->classroom_id,
                'year' => $request->year,
                'fee_type' => $request->fee_type,
                'description' => $request->description,
            ]);
            toastr()->success(trans('messages.success'));
            return redirect()->route('fees.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $fee = Fee::findOrFail($id);
        $grades = Grade::all();
        return view('pages.Fees.edit', compact('fee', 'grades'));
    }

    public function update($request)
    {
        try {
            $fee = Fee::findOrFail($request->id);
            $fee->update([
                'title' => ['ar' => $request->title_ar, 'en' => $request->title_en],
                'amount' => $request->amount,
                'grade_id' => $request->grade_id,
                'classroom_id' => $request->classroom_id,
                'year' => $request->year,
                'fee_type' => $request->fee_type,
                'description' => $request->description,
            ]);
            toastr()->success(trans('messages.success'));
            return redirect()->route('fees.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function show($id) {}

    public function destroy($request)
    {
        try {
            $fee = Fee::findOrFail($request->id)->delete();
            toastr()->success(trans('messages.Delete'));
            return redirect()->route('fees.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
