<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //
    public function showRegistrationForm()
    {
        return view('Auth.register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|unique:users|alpha_num|max:255',
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'password' => 'required|string|confirmed|min:8',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'password' => Hash::make($request->password),
            'level' => 'user', // ค่า default สำหรับ user_level
        ]);

        return redirect()->route('showLoginForm')->with('success', 'การลงทะเบียนสำเร็จ กรุณาเข้าสู่ระบบ');
    }

    public function showLoginForm()
    {
        return view('Auth.login');
    }

    // public function login(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'phone_number' => 'required|string',
    //         'password' => 'required|string',
    //     ]);

    //     if ($validator->fails()) {
    //         return redirect()->back()->withErrors($validator)->withInput();
    //     }

    //     $user = User::findByPhoneNumber($request->phone_number);

    //     if ($user && Hash::check($request->password, $user->password)) {
    //         Auth::login($user);
    //         if ($user->level === 'user') {
    //             return redirect()->route('showUserindex')->with('success', 'การเข้าสู่ระบบสำเร็จแล้ว');
    //         } elseif ($user->level === 'admin') {
    //             return redirect()->route('showAdminindex')->with('success', 'การเข้าสู่ระบบสำเร็จแล้ว');
    //     }
    //     }

    //     return redirect()->back()->withErrors(['showLoginForm' => 'หมายเลขโทรศัพท์หรือรหัสผ่านไม่ถูกต้อง'])->withInput();
    // }
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'login_input' => 'required|string', // ใช้ field ใหม่ชื่อ login_input แทน
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // ค้นหาผู้ใช้จากเบอร์มือถือหรือชื่อ
        $user = User::where('phone_number', $request->login_input)
                    ->orWhere('name', $request->login_input)
                    ->first();

        // ตรวจสอบรหัสผ่าน
        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);

            // ตรวจสอบระดับ (level) ของผู้ใช้
            if ($user->level === 'user') {
                return redirect()->route('showUserindex')->with('success', 'การเข้าสู่ระบบสำเร็จแล้ว');
            } elseif ($user->level === 'admin') {
                return redirect()->route('showAdminindex')->with('success', 'การเข้าสู่ระบบสำเร็จแล้ว');
            }
        }

        // ถ้าข้อมูลไม่ถูกต้อง
        return redirect()->back()->withErrors(['showLoginForm' => 'หมายเลขโทรศัพท์หรือชื่อหรือรหัสผ่านไม่ถูกต้อง'])->withInput();
    }


    public function logout()
    {
        Auth::logout();
        return redirect()->route('showLoginForm')->with('success', 'ออกจากระบบสำเร็จแล้ว');
    }
}
