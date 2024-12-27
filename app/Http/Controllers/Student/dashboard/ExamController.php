<?php

namespace App\Http\Controllers\Student\dashboard;

use App\Models\Quizze;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ExamController extends Controller
{
    public function index()
    {
        $quizzes = Quizze::where('grade_id', Auth::user()->grade_id)
            ->where('classroom_id', Auth::user()->classroom_id)
            ->where('section_id', Auth::user()->section_id)
            ->orderBy('id', 'DESC')
            ->get();
        return view('pages.Students.dashboard.exams.index', compact('quizzes'));
    }
    public function show($locale, $quizze_id)
    {
        $student_id = Auth::user()->id;
        return view('pages.Students.dashboard.exams.show', compact('quizze_id', 'student_id'));
    }
}
