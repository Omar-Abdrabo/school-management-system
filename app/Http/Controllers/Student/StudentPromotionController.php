<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;
use App\Models\StudentPromotion;
use App\Http\Controllers\Controller;
use App\Repositories\StudentPromotionRepositoryInterface;

class StudentPromotionController extends Controller
{

    public function __construct(protected StudentPromotionRepositoryInterface $studentPromotionRepo) {}



    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->studentPromotionRepo->index();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->studentPromotionRepo->create();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $validated = $request->validate([
        //     'grade_id' => 'required|exists:grades,id',
        //     'classroom_id' => 'required|exists:classrooms,id',
        //     'section_id' => 'required|exists:sections,id',
        //     'academic_year' => 'required',
        //     'grade_id_new' => 'required|exists:grades,id',
        //     'classroom_id_new' => 'required|exists:classrooms,id',
        //     'section_id_new' => 'required|exists:sections,id',
        //     'academic_year_new' => 'required',
        // ]);
        
        return $this->studentPromotionRepo->store($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(StudentPromotion $studentPromotion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StudentPromotion $studentPromotion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StudentPromotion $studentPromotion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        return $this->studentPromotionRepo->destroy($request);
    }
}
