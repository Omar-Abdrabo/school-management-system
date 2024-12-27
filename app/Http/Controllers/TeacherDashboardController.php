<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Quizze;
use App\Models\Section;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Question;
use App\Models\Classroom;
use App\Models\OnlineClasse;
use Illuminate\Http\Request;
use Jubaer\Zoom\Facades\Zoom;
use App\Models\StudentAttendance;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\MeetingZoomTrait;
use App\Models\Degree;
use App\Models\Teacher;
use Illuminate\Support\Facades\Hash;

class TeacherDashboardController extends Controller
{
    use MeetingZoomTrait;

    public function get_teacher_students()
    {
        $ids = DB::table('teacher_section')->where('teacher_id', Auth::user()->id)->pluck('section_id');
        $students = Student::with('studentAttendance')->whereIn('section_id', $ids)->get();
        return view('pages.Teachers.dashboard.students.index', compact('students'));
    }

    public function get_teacher_sections()
    {
        $ids = DB::table('teacher_section')->where('teacher_id', Auth::user()->id)->pluck('section_id');
        $sections = Section::whereIn('id', $ids)->get();
        return view('pages.Teachers.dashboard.sections.index', compact('sections'));
    }

    // STUDENT ATTENDANCE
    public function attendance(Request $request)
    {
        try {
            foreach ($request->attendances as $student_id => $studentAttendance) {
                if ($studentAttendance == 'presence') {
                    $attendance_status = true;
                } else if ($studentAttendance == 'absent') {
                    $attendance_status = false;
                }
                StudentAttendance::UpdateOrCreate(
                    [
                        'student_id' => $student_id,
                        'attendance_date' => date('Y-m-d'),
                    ],
                    [
                        'student_id' => $student_id,
                        'grade_id' => $request->grade_id,
                        'classroom_id' => $request->classroom_id,
                        'section_id' => $request->section_id,
                        'teacher_id' => Auth::user()->id,
                        'attendance_date' => date('Y-m-d'),
                        'attendance_status' => $attendance_status
                    ]
                );
            }
            toastr()->success(trans('messages.success'));
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function attendance_edit(Request $request)
    {
        // dd($request);
        try {
            $date = date('Y-m-d');
            $studentAttendance = StudentAttendance::where('attendance_date', $date)->where('student_id', $request->id)->first();
            if ($request->attendances[$request->id] == 'presence') {
                $attendance_status = true;
            } else if ($request->attendances[$request->id]  == 'absent') {
                $attendance_status = false;
            } else {
                return redirect()->back()->withErrors(['error' => 'Invalid attendance status.']);
            }
            $studentAttendance->update([
                'attendance_status' => $attendance_status
            ]);
            toastr()->success(trans('messages.Update'));
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function attendance_report()
    {
        $ids = DB::table('teacher_section')->where('teacher_id', Auth::user()->id)->pluck('section_id');
        $students = Student::whereIn('section_id', $ids)->get();
        return view('pages.Teachers.dashboard.students.attendance_report', compact('students'));
    }

    public function attendance_report_search(Request $request)
    {
        $request->validate([
            'from'  => 'required|date|date_format:Y-m-d',
            'to' => 'required|date|date_format:Y-m-d|after_or_equal:from'
        ], [
            'to.after_or_equal' => 'تاريخ النهاية لابد ان اكبر من تاريخ البداية او يساويه',
            'from.date_format' => 'صيغة التاريخ يجب ان تكون yyyy-mm-dd',
            'to.date_format' => 'صيغة التاريخ يجب ان تكون yyyy-mm-dd',
        ]);

        $ids = DB::table('teacher_section')->where('teacher_id', Auth::user()->id)->pluck('section_id');
        $students = Student::whereIn('section_id', $ids)->get();
        if ($request->student_id == 0) {
            $studentAttendance = StudentAttendance::whereBetween('attendance_date', [$request->from, $request->to])->get();
            // dd($studentAttendance);
            return view('pages.Teachers.dashboard.students.attendance_report', compact('studentAttendance', 'students'));
        } else {
            $studentAttendance = StudentAttendance::whereBetween('attendance_date', [$request->from, $request->to])->where('student_id', $request->student_id)->get();
            // dd($studentAttendance);
            return view('pages.Teachers.dashboard.students.attendance_report', compact('studentAttendance', 'students'));
        }
    }
    // END STUDENT ATTENDANCE

    // QUIZZES
    public function quizze_index()
    {
        $quizzes = Quizze::where('teacher_id', Auth::user()->id)->get();
        return view('pages.Teachers.dashboard.Quizzes.index', compact('quizzes'));
    }

    public function quizze_create()
    {
        $data['grades'] = Grade::all();
        $data['subjects'] = Subject::where('teacher_id', Auth::user()->id)->get();
        return view('pages.Teachers.dashboard.Quizzes.create', $data);
    }

    public function quizze_store(Request $request)
    {
        // dd($request);
        try {
            Quizze::create([
                'name' => ['en' => $request->name_en, 'ar' => $request->name_ar],
                'subject_id' => $request->subject_id,
                'teacher_id' => Auth::user()->id,
                'grade_id' => $request->grade_id,
                'classroom_id' => $request->classroom_id,
                'section_id' => $request->section_id,
            ]);
            toastr()->success(trans('messages.success'));
            return redirect()->route('teacher.quizzes.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function quizze_edit($id)
    {
        $quizze = Quizze::findorFail($id);
        $grades = Grade::all();
        $subjects = Subject::all();
        return view('pages.Teachers.dashboard.Quizzes.edit', compact('quizze', 'grades', 'subjects'));
    }

    public function quizze_update(Request $request)
    {
        // dd($request);
        try {
            $quizze = Quizze::findorFail($request->id);
            $quizze->update([
                'name' => ['en' => $request->name_en, 'ar' => $request->name_ar],
                'subject_id' => $request->subject_id,
                'teacher_id' => Auth::user()->id,
                'grade_id' => $request->grade_id,
                'classroom_id' => $request->classroom_id,
                'section_id' => $request->section_id,
            ]);
            toastr()->success(trans('messages.Update'));
            return redirect()->route('teacher.quizzes.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function quizze_destroy(Request $request)
    {
        try {
            Quizze::destroy($request->id);
            toastr()->error(trans('messages.Delete'));
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function get_quizze_students($quizze_id)
    {
        $degrees = Degree::where('quizze_id', $quizze_id)->get();
        return view('pages.Teachers.dashboard.Quizzes.student_quizze', compact('degrees'));
    }

    public function quizze_students_repeat(Request $request)
    {
        // dd($request);
        Degree::where('student_id', $request->student_id)->where('quizze_id', $request->quizze_id)->delete();
        toastr()->success('تم فتح الاختبار مرة اخرى للطالب');
        return redirect()->back();
    }
    // END QUIZZES

    // QUESTIONS
    public function get_quizze_questions($quizze_id)
    {
        $questions = Question::where('quizze_id', $quizze_id)->get();
        $quizze = Quizze::findorFail($quizze_id);
        return view('pages.Teachers.dashboard.Questions.index', compact('questions', 'quizze'));
    }

    public function quizze_questions_create($quizze_id)
    {
        $quizze = Quizze::findorFail($quizze_id);
        return view('pages.Teachers.dashboard.Questions.create', compact('quizze'));
    }

    public function quizze_questions_store(Request $request)
    {
        // dd($request);
        try {
            Question::create([
                'title' => $request->title,
                'answers' => $request->answers,
                'correct_answers' => $request->correct_answer,
                'score' => $request->score,
                'quizze_id' => $request->quizze_id,
            ]);
            toastr()->success(trans('messages.success'));
            return redirect()->route('teacher.questions', $request->quizze_id);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function quizze_questions_edit($id)
    {
        $question = Question::findorFail($id);
        return view('pages.Teachers.dashboard.Questions.edit', compact('question'));
    }

    public function quizze_questions_update(Request $request)
    {
        // dd($request);
        try {
            $question = Question::findOrFail($request->id);
            $question->update([
                'title' => $request->title,
                'answers' => $request->answers,
                'correct_answers' => $request->correct_answers,
                'score' => $request->score,
            ]);
            toastr()->success(trans('messages.Update'));
            return redirect()->route('teacher.quizzes.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['errors' => $e->getMessage()]);
        }
    }

    public function quizze_questions_destroy(Request $request)
    {
        // dd($request);
        try {
            Question::destroy($request->id);
            toastr()->error(trans('messages.Delete'));
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
    // END QUESTIONS

    // Online Class With ZOOM
    public function online_class_index()
    {
        $online_classes = OnlineClasse::where('created_by', Auth::user()->email)->get();
        return view('pages.Teachers.dashboard.online_classes.index', compact('online_classes'));
    }

    public function online_class_create()
    {
        $grades = Grade::all();
        return view('pages.Teachers.dashboard.online_classes.add', compact('grades'));
    }

    public function online_class_store(Request $request)
    {
        // dd($request);
        try {
            $meeting = $this->createMeeting($request);
            // dd($meeting['data']);
            OnlineClasse::create([
                'integration' => true,
                'grade_id' => $request->grade_id,
                'classroom_id' => $request->classroom_id,
                'section_id' => $request->section_id,
                'created_by' => Auth::user()->email,
                'meeting_id' => $meeting['data']['id'],
                'topic' => $request->topic,
                'start_at' => $request->start_time,
                'duration' => $meeting['data']['duration'],
                'password' => $meeting['data']['password'],
                'start_url' => $meeting['data']['start_url'],
                'join_url' => $meeting['data']['join_url'],
            ]);
            toastr()->success(trans('messages.success'));
            return redirect()->route('teacher.online_class.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function online_class_indirect_create()
    {
        $grades = Grade::all();
        return view('pages.Teachers.dashboard.online_classes.indirect', compact('grades'));
    }

    public function online_class_indirect_store(Request $request)
    {
        $request->validate([
            'grade_id' => 'required',
            'classroom_id' => 'required',
            'section_id' => 'required',
            'meeting_id' => 'required',
            'topic' => 'required',
            'start_time' => 'required',
            'duration' => 'required',
            'password' => 'required',
            'start_url' => 'required',
            'join_url' => 'required',
        ]);
        // dd($request->all());
        try {
            OnlineClasse::create([
                'integration' => false,
                'grade_id' => $request->grade_id,
                'classroom_id' => $request->classroom_id,
                'section_id' => $request->section_id,
                'created_by' => Auth::user()->email,
                'meeting_id' => $request->meeting_id,
                'topic' => $request->topic,
                'start_at' => $request->start_time,
                'duration' => $request->duration,
                'password' => $request->password,
                'start_url' => $request->start_url,
                'join_url' => $request->join_url,
            ]);
            toastr()->success(trans('messages.success'));
            return redirect()->route('teacher.online_class.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function online_class_destroy(Request $request)
    {
        try {
            // $info = OnlineClasse::find($request->classroom_id);
            // if ($info->integration == true) {
            //     $meeting = Zoom::meeting()->find($request->meeting_id);
            //     $meeting->delete();
            //     OnlineClasse::destroy($request->classroom_id);
            // } else {
            //     OnlineClasse::destroy($request->classroom_id);
            // }
            $meeting = Zoom::deleteMeeting($request->meeting_id); // REMOVE IT if you dont integrate with ZOOM
            OnlineClasse::where('meeting_id', $request->meeting_id)->delete();
            toastr()->error(trans('messages.Delete'));
            return redirect()->route('teacher.online_class.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
    // END Online Class With ZOOM

    // Profile
    public function profile()
    {
        $information  = Teacher::find(Auth::user()->id);
        return view('pages.Teachers.dashboard.profile', compact('information'));
    }

    public function profile_update(Request $request)
    {
        $request->validate([
            'name_ar' => 'required',
            'name_en' => 'required',
            'password' => 'nullable|min:8',
        ]);
        $information = Teacher::find(Auth::user()->id);
        if (!empty($request->password)) {
            $information->name = ['ar' => $request->name_ar, 'en' => $request->name_en];
            $information->password = Hash::make($request->password);
            $information->save();
        } else {
            $information->name = ['ar' => $request->name_ar, 'en' => $request->name_en];
            $information->save();
        }
        toastr()->success(trans('messages.Update'));
        return redirect()->route('teacher.profile');
    }
    // END Profile

    // AJAX
    public function getClassrooms($id)
    {
        //  Classroom::where('grade_id', $id)->pluck('name_class', 'id')
        $list_classes = Grade::find($id)->classrooms()->pluck('name_class', 'id');
        return $list_classes;
    }

    public function getSections($id)
    {
        $grade =  Classroom::find($id)->grade()->pluck('id');
        $list_sections = Classroom::find($id)->sections()->where('grade_id', $grade)->pluck('section_name', 'id');
        return $list_sections;
    }
    // END AJAX

}
