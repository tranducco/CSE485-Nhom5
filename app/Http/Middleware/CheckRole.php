<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     * $roles là tham số động (có thể truyền vào 'admin', 'student', 'lecturer')
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // 1. Kiểm tra xem đã đăng nhập chưa
        if (!Auth::check()) {
            return redirect('/login');
        }

        // 2. Kiểm tra xem role của người dùng có nằm trong danh sách được phép không
        if (!in_array(Auth::user()->role, $roles)) {
            // Nếu không có quyền, đá văng ra lỗi 403 Forbidden
            abort(403, 'CẢNH BÁO: Bạn không có quyền truy cập vào khu vực này!');
        }

        // 3. Cho phép đi tiếp nếu đúng role
        return $next($request);
    }
}