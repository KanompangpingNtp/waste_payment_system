<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckIfLoggedIn
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // ตรวจสอบว่าเป็นผู้ใช้ที่ล็อกอินอยู่หรือไม่
        if (!Auth::check()) {
            // ถ้าไม่ใช่ ให้ Redirect ไปที่หน้า login
            return redirect()->route('showLoginForm')->with('error', 'You need to be logged in to access this page.');
        }

        return $next($request);
    }
}
