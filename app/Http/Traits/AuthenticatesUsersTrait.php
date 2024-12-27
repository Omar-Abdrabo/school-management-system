<?php

namespace App\Http\Traits;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider;

trait AuthenticatesUsersTrait
{
    const GUARD_STUDENT = 'student';
    const GUARD_TEACHER = 'teacher';
    const GUARD_PARENT = 'parent';
    const GUARD_ADMIN = 'admin';
    const GUARD_WEB = 'web';

    public function chekGuard($request)
    {
        switch ($request->type) {
            case 'student':
                return self::GUARD_STUDENT;;
            case 'teacher':
                return self::GUARD_TEACHER;
            case 'parent':
                return self::GUARD_PARENT;
            case 'admin':
                return self::GUARD_ADMIN;
            default:
                return self::GUARD_WEB;
        }
    }

    public function redirect($request)
    {
        // dd($request->type);
        if ($request->type == 'student') {
            // dd('student');
            return redirect()->intended(route('student.dashboard', app()->getLocale()));
        } elseif ($request->type == 'teacher') {
            return redirect()->intended(route('teacher.dashboard', app()->getLocale()));
        } elseif ($request->type == 'parent') {
            return redirect()->intended(route('parent.dashboard', app()->getLocale()));
        } elseif ($request->type == 'admin') {
            return redirect()->intended(route('dashboard', app()->getLocale()));
        }
    }
}
