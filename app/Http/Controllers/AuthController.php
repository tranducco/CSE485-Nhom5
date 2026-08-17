<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Hiển thị form đăng nhập
    public function showLogin()
    {
        return view('auth.login');
    }

    // Xử lý đăng nhập
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // ĐIỀU HƯỚNG TỰ ĐỘNG DỰA VÀO ROLE
            $user = Auth::user();
            if ($user->role === 'student') {
                return redirect()->route('student.topics.index');
            } elseif ($user->role === 'admin') {
                return redirect('/topic-registrations'); // Link trang chủ Admin hiện tại của cậu
            }

            // Nếu không có role cụ thể, đẩy về trang chủ mặc định
            return redirect('/');
        }

        return back()->withErrors([
            'email' => 'Email hoặc mật khẩu không chính xác.',
        ])->onlyInput('email');
    }

    // Xử lý đăng xuất
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login'); 
    }
}