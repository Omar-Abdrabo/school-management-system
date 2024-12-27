<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\QuizzeController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\Student\FeeController;
use App\Http\Controllers\Grades\GradeController;
use App\Http\Controllers\OnlineClasseController;
use App\Http\Controllers\Student\StudentController;
use App\Http\Controllers\Sections\SectionController;
use App\Http\Controllers\Student\FeeInvoiceController;
use App\Http\Controllers\Classroom\ClassroomController;
use App\Http\Controllers\Student\ProcessingFeeController;
use App\Http\Controllers\Student\PaymentStudentController;
use App\Http\Controllers\Student\StudentReceiptController;
use App\Http\Controllers\Student\GraduatedStudentController;
use App\Http\Controllers\Student\StudentPromotionController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\Student\StudentAttendanceController;


// ADMIN Guarded ROUTES
Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'auth:admin']
    ],
    function () {
        /** ADD ALL LOCALIZED ROUTES INSIDE THIS GROUP **/

        // Grade ROUTES
        Route::controller(GradeController::class)->group(function () {
            Route::resource('grades', GradeController::class);
            Route::patch('grades/update', 'update')->name('grades.update');
            Route::delete('grades/destroy', 'destroy')->name('grades.destroy');
        });

        // CLASSROOM ROUTES
        Route::controller(ClassroomController::class)->group(function () {
            Route::resource('classrooms', ClassroomController::class);
            Route::patch('classrooms/update', 'update')->name('classrooms.update');
            Route::delete('classrooms/destroy', 'destroy')->name('classrooms.destroy');
            Route::post('classrooms/delete_selected', 'delete_selected')->name('classrooms.delete_selected');
            Route::post('classrooms/filter', 'filter')->name('classrooms.filter');
        });

        // SECTION ROUTES
        Route::controller(SectionController::class)->group(function () {
            // Route::resource('sections', SectionController::class);
            Route::get('sections', 'index')->name('sections.index');
            Route::post('sections/store', 'store')->name('sections.store');
            Route::patch('sections/update', 'update')->name('sections.update');
            Route::delete('sections/destroy', 'destroy')->name('sections.destroy');
            Route::get('/classes/{id}', 'getClassrooms');
            // Route::post('sections/delete_selected', 'delete_selected')->name('sections.delete_selected');
        });

        // Teacher ROUTES
        Route::controller(TeacherController::class)->group(function () {
            Route::resource('teachers', TeacherController::class);
        });

        // Student ROUTES
        Route::controller(StudentController::class)->group(function () {
            Route::resource('students', StudentController::class);
            Route::get('get_classrooms/{id}', 'getClassrooms');
            Route::get('get_sections/{id}', 'getSections');
            Route::post('upload_attachment', 'upload_attachment')->name('upload_attachment');
            Route::post('students/delete_attachment', 'delete_attachment')->name('delete_attachment');
            Route::get('students/download_attachment/{student_name}/{file_name}', 'download_attachment')->name('download_attachment');
        });

        // Student Pormotion ROUTES 
        Route::controller(StudentPromotionController::class)->group(function () {
            Route::get('promotions', 'index')->name('promotion.index');
            Route::post('promotions/store', 'store')->name('promotion.store');
            Route::get('promotions/create', 'create')->name('promotion.create');
            Route::get('promotions/edit/{id}', 'edit')->name('promotion.edit');
            Route::patch('promotions/update', 'update')->name('promotion.update');
            Route::delete('promotions/destroy', 'destroy')->name('promotion.destroy');
        });

        // Graduated Student ROUTES
        Route::controller(GraduatedStudentController::class)->group(function () {
            Route::get('graduated_students', 'index')->name('graduated.index');
            Route::post('graduated_students/store', 'store')->name('graduated.store');
            Route::get('graduated_students/create', 'create')->name('graduated.create');
            Route::get('graduated_students/edit/{id}', 'edit')->name('graduated.edit');
            Route::PUT('graduated_students/update', 'update')->name('graduated.update');
            Route::delete('graduated_students/destroy', 'destroy')->name('graduated.destroy');
        });

        // FEES ROUTES
        Route::controller(FeeController::class)->group(function () {
            Route::get('fees', 'index')->name('fees.index');
            Route::post('fees/store', 'store')->name('fees.store');
            Route::get('fees/create', 'create')->name('fees.create');
            Route::get('fees/edit/{id}', 'edit')->name('fees.edit');
            Route::PUT('fees/update', 'update')->name('fees.update');
            Route::delete('fees/destroy', 'destroy')->name('fees.destroy');
        });

        //FEES INVOICES ROUTES

        Route::controller(FeeInvoiceController::class)->group(function () {
            Route::get('fee_invoices', 'index')->name('fee_invoices.index');
            Route::post('fee_invoices/store', 'store')->name('fee_invoices.store');
            Route::get('fee_invoices/create', 'create')->name('fee_invoices.create');
            Route::get('fee_invoices/edit/{id}', 'edit')->name('fee_invoices.edit');
            Route::PUT('fee_invoices/update', 'update')->name('fee_invoices.update');
            Route::delete('fee_invoices/destroy', 'destroy')->name('fee_invoices.destroy');
            Route::get('fee_invoices/show/{id}', 'show')->name('fee_invoices.show');
            Route::get('fee_invoices/print/{id}', 'print')->name('fee_invoices.print');
        });

        // STUDENT RECEIPT ROUTES
        Route::controller(StudentReceiptController::class)->group(function () {
            Route::get('student_receipts', 'index')->name('student_receipts.index');
            Route::post('student_receipts/store', 'store')->name('student_receipts.store');
            Route::get('student_receipts/create', 'create')->name('student_receipts.create');
            Route::get('student_receipts/edit/{id}', 'edit')->name('student_receipts.edit');
            Route::PUT('student_receipts/update', 'update')->name('student_receipts.update');
            Route::delete('student_receipts/destroy', 'destroy')->name('student_receipts.destroy');
            Route::get('student_receipts/show/{id}', 'show')->name('student_receipts.show');
            // Route::get('student_receipts/print/{id}', 'print')->name('student_receipts.print');
        });

        // PROCESSING FEE ROUTES

        Route::controller(ProcessingFeeController::class)->group(function () {
            Route::get('processing_fees', 'index')->name('processing_fees.index');
            Route::post('processing_fees/store', 'store')->name('processing_fees.store');
            Route::get('processing_fees/create', 'create')->name('processing_fees.create');
            Route::get('processing_fees/edit/{id}', 'edit')->name('processing_fees.edit');
            Route::PUT('processing_fees/update', 'update')->name('processing_fees.update');
            Route::delete('processing_fees/destroy', 'destroy')->name('processing_fees.destroy');
            Route::get('processing_fees/show/{id}', 'show')->name('processing_fees.show');
        });

        // STUDENT PAYMENT ROUTES
        Route::controller(PaymentStudentController::class)->group(function () {
            Route::get('payment_students', 'index')->name('payment_students.index');
            Route::post('payment_students/store', 'store')->name('payment_students.store');
            Route::get('payment_students/create', 'create')->name('payment_students.create');
            Route::get('payment_students/edit/{id}', 'edit')->name('payment_students.edit');
            Route::PUT('payment_students/update', 'update')->name('payment_students.update');
            Route::delete('payment_students/destroy', 'destroy')->name('payment_students.destroy');
            Route::get('payment_students/show/{id}', 'show')->name('payment_students.show');
        });

        // STUDENT ATTENDANCE ROUTES
        Route::controller(StudentAttendanceController::class)->group(function () {
            Route::get('student_attendances', 'index')->name('student_attendances.index');
            Route::post('student_attendances/store', 'store')->name('student_attendances.store');
            Route::get('student_attendances/create', 'create')->name('student_attendances.create');
            Route::get('student_attendances/edit/{id}', 'edit')->name('student_attendances.edit');
            Route::PUT('student_attendances/update', 'update')->name('student_attendances.update');
            Route::delete('student_attendances/destroy', 'destroy')->name('student_attendances.destroy');
            Route::get('student_attendances/show/{id}', 'show')->name('student_attendances.show');
        });

        // Sjbject ROUTES
        Route::controller(SubjectController::class)->group(function () {
            Route::get('subjects', 'index')->name('subjects.index');
            Route::post('subjects/store', 'store')->name('subjects.store');
            Route::get('subjects/create', 'create')->name('subjects.create');
            Route::get('subjects/edit/{id}', 'edit')->name('subjects.edit');
            Route::PUT('subjects/update', 'update')->name('subjects.update');
            Route::delete('subjects/destroy', 'destroy')->name('subjects.destroy');
        });

        // EXAM ROUTES
        Route::controller(ExamController::class)->group(function () {
            Route::get('exams', 'index')->name('exams.index');
            Route::post('exams/store', 'store')->name('exams.store');
            Route::get('exams/create', 'create')->name('exams.create');
            Route::get('exams/edit/{id}', 'edit')->name('exams.edit');
            Route::patch('exams/update', 'update')->name('exams.update');
            Route::delete('exams/destroy', 'destroy')->name('exams.destroy');
        });

        // QUIZZES ROUTES
        Route::controller(QuizzeController::class)->group(function () {
            Route::get('quizzes', 'index')->name('quizzes.index');
            Route::post('quizzes/store', 'store')->name('quizzes.store');
            Route::get('quizzes/create', 'create')->name('quizzes.create');
            Route::get('quizzes/edit/{id}', 'edit')->name('quizzes.edit');
            Route::put('quizzes/update', 'update')->name('quizzes.update');
            Route::delete('quizzes/destroy', 'destroy')->name('quizzes.destroy');
        });

        // QUESTIONS ROUTES
        Route::controller(QuestionController::class)->group(function () {
            Route::get('questions', 'index')->name('questions.index');
            Route::post('questions/store', 'store')->name('questions.store');
            Route::get('questions/create', 'create')->name('questions.create');
            Route::get('questions/edit/{id}', 'edit')->name('questions.edit');
            Route::put('questions/update', 'update')->name('questions.update');
            Route::delete('questions/destroy', 'destroy')->name('questions.destroy');
        });

        // ONLINE CLASSE ROUTES
        Route::controller(OnlineClasseController::class)->group(function () {
            Route::get('online_classes', 'index')->name('online_classes.index');
            Route::post('online_classes/store', 'store')->name('online_classes.store');
            Route::get('online_classes/create', 'create')->name('online_classes.create');
            Route::get('online_classes/edit/{id}', 'edit')->name('online_classes.edit');
            Route::put('online_classes/update', 'update')->name('online_classes.update');
            Route::delete('online_classes/destroy', 'destroy')->name('online_classes.destroy');
            Route::get('online_classes/indirectCreate', 'indirectCreate')->name('indirect_online_classes.create');
            Route::post('online_classes/indirectStore', 'indirectStore')->name('indirect_online_classes.store');
        });

        // LIBRARY ROUTES
        Route::controller(LibraryController::class)->group(function () {
            Route::get('library', 'index')->name('library.index');
            Route::post('library/store', 'store')->name('library.store');
            Route::get('library/create', 'create')->name('library.create');
            Route::get('library/edit/{id}', 'edit')->name('library.edit');
            Route::put('library/update', 'update')->name('library.update');
            Route::delete('library/destroy', 'destroy')->name('library.destroy');
            Route::get('download_file/{file_name}', 'downloadFile')->name('download_file');
        });

        // SETTINGS ROUTES
        Route::controller(SettingController::class)->group(function () {
            Route::get('settings', 'index')->name('settings.index');
            Route::put('settings/update', 'update')->name('settings.update');
        });
    }
);
//*************************************************** 
// ROUTES FOR LIVEWIRE AND MCAMARA TOGETHER 
Route::group(['prefix' => '{locale}', 'middleware' => ['set_locale', 'auth:admin']], function () {
    Route::view('add_parent', 'livewire.show_Form')->name('add_parent');

    // DASHBOARD ROUTES
    Route::controller(HomeController::class)->group(function () {
        Route::get('dashboard', 'dashboard')->name('dashboard');
    });

    // Route::get('/test', function () {
    //     return view('test_pg');
    // });
});
// END ROUTES FOR ADMIN
