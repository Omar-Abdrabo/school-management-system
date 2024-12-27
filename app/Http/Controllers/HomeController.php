<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('auth.selection');
    }

    public function dashboard()
    {
        // dd('dashboard');
        return view('dashboard');
    }
}
