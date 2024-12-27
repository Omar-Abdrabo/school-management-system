<?php

namespace App\Http\Controllers\Parent\dashboard;

use App\Models\Fee;
use App\Models\Student;
use App\Models\MyParent;
use App\Models\FeeInvoice;
use Illuminate\Http\Request;
use App\Models\StudentReceipt;
use App\Models\StudentAttendance;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ChildrenController extends Controller
{
    public function index()
    {
        $students = Student::where('parent_id', Auth::user()->id)->get();
        return view('pages.parents.children.index', compact('students'));
    }

    public function results($id)
    {
        $student = Student::findOrFail($id);
        if ($student->parent_id !== Auth::user()->id) {
            toastr()->error('يوجد خطا في كود الطالب');
            return redirect()->route('parent.children.index');
        }
        $degrees = $student->degrees;
        // dd($degrees);
        if ($degrees->isEmpty()) {
            toastr()->error('لا توجد نتائج لهذا الطالب');
            return redirect()->route('parent.children.index');
        }
        return view('pages.parents.degrees.index', compact('degrees'));
    }
    // Attendance
    public function attendances()
    {
        $students = Student::where('parent_id', Auth::user()->id)->get();
        return view('pages.parents.Attendance.index', compact('students'));
    }
    public function attendanceSearch(Request $request)
    {
        $request->validate([
            'from' => 'required|date|date_format:Y-m-d',
            'to' => 'required|date|date_format:Y-m-d|after_or_equal:from'
        ], [
            'to.after_or_equal' => 'تاريخ النهاية لابد ان اكبر من تاريخ البداية او يساويه',
            'from.date_format' => 'صيغة التاريخ يجب ان تكون yyyy-mm-dd',
            'to.date_format' => 'صيغة التاريخ يجب ان تكون yyyy-mm-dd',
        ]);
        $ids = Student::where('parent_id', Auth::user()->id)->pluck('id');
        $students = Student::whereIn('id', $ids)->get();
        if ($request->student_id == 0) {
            $student_atendances = StudentAttendance::whereIn('student_id', $ids)->whereBetween('attendance_date', [$request->from, $request->to])->get();
            return view('pages.parents.Attendance.index', compact('student_atendances', 'students'));
        } else {
            $student_atendances = StudentAttendance::whereIn('student_id', $ids)->whereBetween('attendance_date', [$request->from, $request->to])
                ->where('student_id', $request->student_id)->get();
            return view('pages.parents.Attendance.index', compact('student_atendances', 'students'));
        }
    }
    // END  Attendance
    // Fees & Recipts
    public function fees()
    {
        $students_ids = Student::where('parent_id', Auth::user()->id)->pluck('id');
        $fee_invoices = FeeInvoice::whereIn('student_id', $students_ids)->get();
        return view('pages.parents.fees.index', compact('fee_invoices'));
    }

    public function reciptStudent($id)
    {
        $student = Student::findOrFail($id);
        if ($student->parent_id !== Auth::user()->id) {
            toastr()->error('يوجد خطا في كود الطالب');
            return redirect()->route('parent.children.index');
        }
        $student_receipts = StudentReceipt::where('student_id', $id)->get();
        if ($student_receipts->isEmpty()) {
            toastr()->error('لا توجد مدفوعات لهذا الطالب');
            return redirect()->route('parent.children.index');
        }
        return view('pages.parents.Receipt.index', compact('student_receipts'));
    }
    // END  Fees & Recipts
    // Profile
    public function profile()
    {
        $information = MyParent::findOrFail(Auth::user()->id);
        return view('pages.parents.profile', compact('information'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'father_name_ar' => 'required',
            'father_name_en' => 'required',
            'password' => 'nullable|min:8',
        ]);
        $information = MyParent::find(Auth::user()->id);
        if (!empty($request->password)) {
            $information->father_name = ['ar' => $request->father_name_ar, 'en' => $request->father_name_en];
            $information->password = Hash::make($request->password);
            $information->save();
        } else {
            $information->father_name = ['ar' => $request->father_name_ar, 'en' => $request->father_name_en];
            $information->save();
        }
        toastr()->success(trans('messages.Update'));
        return redirect()->route('parent.profile');
    }
    // END Profile
}
