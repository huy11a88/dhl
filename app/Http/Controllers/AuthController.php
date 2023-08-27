<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if ($request->isMethod('get')) {
            return view('login', ['redirectTo' => $request->query('redirect_to')]);
        }

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if (!Auth::attempt($credentials)) {
            return back()->withErrors(['auth' => 'Invalid credentials']);
        }

        $request->session()->regenerate();

        if ($request->user()->role === UserRole::CUSTOMER_SERVICE_STAFF) {
            return redirect()->route('customer-service');
        }

        if ($redirectTo = $request->input('redirect-to')) {
            return redirect()->route($redirectTo);
        }

        return redirect()->intended('/');
    }

    public function register(Request $request)
    {
        $credentials = $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed']
        ]);

        User::create([...$credentials, 'role' => UserRole::NORMAL_USER]);

        return redirect()->intended('login');
    }

    public function logout(Request $request)
    {
        Auth::logout();
 
        $request->session()->invalidate();
     
        $request->session()->regenerateToken();
     
        return redirect('/login');
    }
}
