<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function index()
    {
        return view('login');
    }

    public function authenticated(Request $request, $user)
    {
        return redirect()->intended($request->url);
    }

    // function member_login(Request $request)
    // {
    //     $request->validate([
    //         'username' => ['required', 'string'],
    //         'password' => ['required'],
    //     ]);

    //     if (Auth::guard('members')->attempt(['no_anggota' => $request->username, 'password' => $request->password])) {
    //         $request->session()->regenerate();

    //         return redirect()->route('dashboard.member');
    //     }

    //     return back()->withErrors([
    //         'username' => 'The provided credentials do not match our records.',
    //     ])->onlyInput('username');
    // }

    // function member_logout(Request $request)
    // {
    //     Auth::guard('members')->logout();
    //     // Auth::logout();

    //     $request->session()->invalidate();

    //     $request->session()->regenerateToken();
    //     return redirect('/');
    // }
}
