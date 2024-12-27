<?php

namespace App\Http\Controllers\Auth;


use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\AuthenticatesUsersTrait;

class LoginController extends Controller
{
    use AuthenticatesUsersTrait;

    public function __construct()
    {
        $this->middleware(['guest'])->except('logout');
    }

    public function loginForm($type)
    {
        return view('auth.login', compact('type'));
    }

    public function login(Request $request)
    {
        // dd($request->all());
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if (Auth::guard($this->chekGuard($request))->attempt($credentials)) {
            $request->session()->regenerate();
            return $this->redirect($request);
        } else {
            session()->forget('url.intended');
            return back()->withErrors(['error' => 'Invalid login credentials']);
        }
        return back()->withErrors(['error' => 'Some THING went WRONG']);
    }

    public function logout(Request $request, $type)
    {
        // dd(Auth::guard($type));
        Auth::guard($type)->logout();
        session()->forget('url.intended');
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
