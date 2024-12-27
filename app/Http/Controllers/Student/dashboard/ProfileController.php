<?php

namespace App\Http\Controllers\Student\dashboard;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $information =  Student::findOrFail(Auth::user()->id);
        return view('pages.Students.dashboard.profile', compact('information'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name_ar' => 'required',
            'name_en' => 'required',
            'password' => 'nullable|min:8',
        ]);
        $information =  Student::findOrFail(Auth::user()->id);
        if (!empty($request->password)) {
            $information->name = ['en' => $request->name_en, 'ar' => $request->name_ar];
            $information->password = Hash::make($request->password);
            $information->save();
        } else {
            $information->name = ['en' => $request->name_en, 'ar' => $request->name_ar];
            $information->save();
        }
        toastr()->success(trans('messages.Update'));
        return redirect()->back();
    }
}
