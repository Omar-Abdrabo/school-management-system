<?php


use App\Models\Teacher;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeacherDashboardController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group(
    [
        'prefix' => '{locale}',
        'middleware' => ['set_locale', 'auth:teacher']
    ],
    function () {
        //==============================dashboard============================
        Route::get('teacher/dashboard', function () {
            $ids = Teacher::findorFail(Auth::user()->id)->sections()->pluck('section_id');
            $data['count_sections'] = $ids->count();
            $data['count_students'] = \App\Models\Student::whereIn('section_id', $ids)->count();

            // $ids = DB::table('teacher_section')->where('teacher_id', auth()->user()->id)->pluck('section_id');
            // $data['count_sections'] =  $ids->count();
            // $data['count_students'] = DB::table('students')->whereIn('section_id', $ids)->count();
            return view('pages.Teachers.dashboard.dashboard', $data);
        })->name('teacher.dashboard');
    }
);
Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'auth:teacher']
    ],
    function () {
        //==============================Students============================
        Route::get('teacher/students', [TeacherDashboardController::class, 'get_teacher_students'])->name('tacher.students.index');
        Route::post('teacher/students/attendance', [TeacherDashboardController::class, 'attendance'])->name('teacher.attendance');
        Route::post('teacher/students/attendance/edit', [TeacherDashboardController::class, 'attendance_edit'])->name('teacher.attendance.edit');
        Route::get('teacher/students/attendance_report', [TeacherDashboardController::class, 'attendance_report'])->name('teacher.attendance.report');
        Route::post('teacher/students/attendance_report', [TeacherDashboardController::class, 'attendance_report_search'])->name('teacher.attendance.search');
        // ==============================Sections============================
        Route::get('teacher/sections', [TeacherDashboardController::class, 'get_teacher_sections'])->name('teacher.sections');
        // ==============================Quizzes============================
        Route::controller(TeacherDashboardController::class)->group(function () {
            Route::get('teacher/quizzes', 'quizze_index')->name('teacher.quizzes.index');
            Route::get('teacher/quizzes/create', 'quizze_create')->name('teacher.quizzes.create');
            Route::post('teacher/quizzes/store', 'quizze_store')->name('teacher.quizzes.store');
            Route::get('teacher/quizzes/edit/{id}', 'quizze_edit')->name('teacher.quizzes.edit');
            Route::put('teacher/quizzes/update', 'quizze_update')->name('teacher.quizzes.update');
            Route::delete('teacher/quizzes/destroy', 'quizze_destroy')->name('teacher.quizzes.destroy');
            // ==============================AJAX============================
            Route::get('teacher/get_classrooms/{id}', 'getClassrooms');
            Route::get('teacher/get_sections/{id}', 'getSections');
            // ==============================Questions============================
            Route::get('teacher/questions/{id}', 'get_quizze_questions')->name('teacher.questions');
            Route::get('teacher/questions/create/{id}', 'quizze_questions_create')->name('teacher.questions.create');
            Route::post('teacher/questions/store', 'quizze_questions_store')->name('teacher.questions.store');
            Route::get('teacher/questions/edit/{id}', 'quizze_questions_edit')->name('teacher.questions.edit');
            Route::put('teacher/questions/update', 'quizze_questions_update')->name('teacher.questions.update');
            Route::delete('teacher/questions/destroy', 'quizze_questions_destroy')->name('teacher.questions.destroy');
            // ==============================Quizzes Students============================
            Route::get('teacher/students/quizzes/{id}', 'get_quizze_students')->name('teacher.students.quizzes');
            Route::post('teacher/students/quizzes/repeat', 'quizze_students_repeat')->name('teacher.students.quizzes.repeat');
            // ==============================Online Classroom============================
            Route::get('teacher/online_class', 'online_class_index')->name('teacher.online_class.index');
            Route::get('teacher/online_class/create', 'online_class_create')->name('teacher.online_class.create');
            Route::post('teacher/online_class/store', 'online_class_store')->name('teacher.online_class.store');
            Route::get('teacher/online_class/indirect_create', 'online_class_indirect_create')->name('teacher.online_class.indirect_create');
            Route::post('teacher/online_class/indirect_store', 'online_class_indirect_store')->name('teacher.online_class.indirect_store');
            Route::delete('teacher/online_class/destroy', 'online_class_destroy')->name('teacher.online_class.destroy');
            // ==============================profile============================
            Route::get('teacher/profile', 'profile')->name('teacher.profile');
            Route::post('teacher/profile/update', 'profile_update')->name('teacher.profile.update');
        });
    }
);
