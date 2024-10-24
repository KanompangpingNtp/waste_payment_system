<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminManageUsersController extends Controller
{
    public function showAdminManageUsers()
    {
        $users = User::all();

        return view('Admin.Admin_Manage_Users.admin_manage_users', compact('users'));
    }

    // ฟังก์ชันสร้างผู้ใช้ใหม่
    public function createUser(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required',
            'phone_number' => 'nullable',
            'password' => 'required|min:6',
            'level' => 'required',
        ]);

        // ตรวจสอบว่ามี username หรือ phone_number ที่ซ้ำกันหรือไม่
        $existingUser = User::where('username', $request->username)
            ->orWhere('phone_number', $request->phone_number)
            ->first();

        if ($existingUser) {
            return redirect()->back()->with('error', 'มีการชื่อผู้ใช้หรือเบอร์มือถือซ้ำ');
        } else {
            User::create([
                'name' => $request->name,
                'username' => $request->username,
                'phone_number' => $request->phone_number,
                'address' => $request->address,
                'password' => bcrypt($request->password),
                'level' => $request->level,
            ]);

            return redirect()->back()->with('success', 'สร้างผู้ใช้สำเร็จแล้ว');
        }
    }


    // ฟังก์ชันแก้ไขผู้ใช้
    public function editUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users,username,' . $user->id,
            'level' => 'required',
            'password' => 'nullable|min:6', // เพิ่มการตรวจสอบรหัสผ่านที่เป็น optional
        ]);

        $user->update([
            'name' => $request->name,
            'username' => $request->username,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'level' => $request->level,
            // ถ้ามีการกรอกรหัสผ่านใหม่ ให้อัปเดต
            'password' => $request->password ? bcrypt($request->password) : $user->password,
        ]);

        return redirect()->back()->with('success', 'อัปเดตผู้ใช้สำเร็จแล้ว');
    }


    // ฟังก์ชันลบผู้ใช้
    public function deleteUser($id)
    {
        User::findOrFail($id)->delete();

        return redirect()->back()->with('success', 'ลบผู้ใช้สำเร็จแล้ว');
    }
}
