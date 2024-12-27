<?php

namespace App\Repositories;

use App\Models\Grade;
use App\Models\Student;
use App\Models\StudentPromotion;
use App\Repositories\StudentPromotionRepositoryInterface;
use Illuminate\Support\Facades\DB;

class StudentPromotionRepository implements StudentPromotionRepositoryInterface
{

    public function index()
    {
        $grades = Grade::all();
        return view('pages.Students.promotion.index', compact('grades'));
    }

    public function store($request)
    {
        DB::beginTransaction();
        try {
            $students = Student::where('grade_id', $request->grade_id)->where('classroom_id', $request->classroom_id)->where('section_id', $request->section_id)->where('academic_year', $request->academic_year)->get();
            $ids = $students->pluck('id')->toArray();
            if ($students->count() < 1) {
                return redirect()->back()->with('error_promotions', __('لاتوجد بيانات في جدول الطلاب'));
            }
            foreach ($students as $student) {
                Student::whereIn('id', $ids)->update([
                    'grade_id' => $request->grade_id_new,
                    'classroom_id' => $request->classroom_id_new,
                    'section_id' => $request->section_id_new,
                    'academic_year' => $request->academic_year_new,
                ]);
                StudentPromotion::updateOrCreate([
                    'student_id' => $student->id,
                    'from_grade' => $request->grade_id,
                    'from_classroom' => $request->classroom_id,
                    'from_section' => $request->section_id,
                    'from_academic_year' => $request->academic_year,
                    'to_grade' => $request->grade_id_new,
                    'to_classroom' => $request->classroom_id_new,
                    'to_section' => $request->section_id_new,
                    'to_academic_year' => $request->academic_year_new,
                ]);
            }

            DB::commit();
            toastr()->success(trans('messages.success'));
            return redirect()->route('promotion.index');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function create()
    {
        $promotions = StudentPromotion::all();
        return view('pages.Students.promotion.management', compact('promotions'));
    }

    public function destroy($request)
    {

        DB::beginTransaction();
        try {
            if ($request->page_id == 1) {
                $promotions = StudentPromotion::all();
                // $studentIds = $promotions->pluck('student_id')->toArray();
                foreach ($promotions as $promotion) {
                    $promotion->student()->update([
                        'grade_id' => $promotion->from_grade,
                        'classroom_id' => $promotion->from_classroom,
                        'section_id' => $promotion->from_section,
                        'academic_year' => $promotion->from_academic_year,
                    ]);
                }
                StudentPromotion::truncate();
            } else {
                $promotion = StudentPromotion::findOrFail($request->id);
                $promotion->student()->update([
                    'grade_id' => $promotion->from_grade,
                    'classroom_id' => $promotion->from_classroom,
                    'section_id' => $promotion->from_section,
                    'academic_year' => $promotion->from_academic_year
                ]);
                $promotion->delete();
            }
            DB::commit();
            toastr()->error(trans('messages.Delete'));
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
