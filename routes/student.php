<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Student\dashboard\ExamController as DashboardExamController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\Student\dashboard\ProfileController as StudentProfileController;

// ROUTES FOR LIVEWIRE AND MCAMARA TOGETHER (Studet Dashboard & Student Exam)
Route::group(
    [
        'prefix' => '{locale}',
        'middleware' => ['auth:student', 'set_locale']
    ],
    function () {
        //==============================dashboard============================
        Route::get('/student/dashboard', function () {
            return view('pages.Students.dashboard');
        })->name('student.dashboard');
        //==============================Exam============================
        Route::controller(DashboardExamController::class)->group(function () {
            Route::get('student/exams/show/{id}', 'show')->name('student.exams.show');
        });
    }
);
Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'auth:student'],
        'namespace' => 'App\Http\Controllers\Student\dashboard',
    ],
    function () {
        //==============================Exam============================
        Route::controller(DashboardExamController::class)->group(function () {
            Route::get('student/exams', 'index')->name('student.exams.index');
        });
        //==============================Profile============================
        Route::controller(StudentProfileController::class)->group(function () {
            Route::get('student/profile', 'index')->name('student.profile');
            Route::post('student/profile/update', 'update')->name('student.profile.update');
        });
    }
);
