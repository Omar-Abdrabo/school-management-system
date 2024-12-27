<?php

use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\Parent\dashboard\ChildrenController;



Route::group(
    [
        'prefix' => '{locale}',
        'middleware' => ['auth:parent', 'set_locale']
    ],
    function () {
        //==============================dashboard============================
        Route::get('/parent/dashboard', function () {
            $sons = Student::where('parent_id', Auth::user()->id)->get();
            return view('pages.parents.dashboard', compact('sons'));
        })->name('parent.dashboard');
    }
);
Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'auth:parent'],
        // 'namespace' => 'App\Http\Controllers\Student\dashboard',
    ],
    function () {
        Route::controller(ChildrenController::class)->group(function () {
            //==============================Children============================
            Route::get('parent/children', 'index')->name('parent.children.index');
            Route::get('parent/children/results/{id}', 'results')->name('parent.children.results');
            Route::get('parent/children/attendance', 'attendances')->name('parent.children.attendance');
            Route::post('parent/children/attendance/search', 'attendanceSearch')->name('parent.children.attendance.search');
            // =============================FEES============================
            Route::get('parent/children/fees', 'fees')->name('parent.children.fees');
            Route::get('parent/children/receipt/{id}', 'reciptStudent')->name('parent.children.receipt');
            // =============================Profile============================
            Route::get('parent/profile', 'profile')->name('parent.profile');
            Route::post('parent/profile/update', 'updateProfile')->name('parent.profile.update');
        });
    }
);
