<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminshowbilluserController extends Controller
{
    //
    public function showAdminBillindex()
    {
        $users = User::where('level', 'user')
            ->with([
                'bills' => function ($query) {
                    $query->whereIn('status', ['pending', 'unpaid']);
                }
            ])
            ->get()
            ->map(function ($user) {
                $user->total_due = $user->bills->sum('amount'); // คำนวณยอดค้างชำระรวม

                // คำนวณจำนวนวันที่ค้างชำระ
                $user->total_overdue_days = $user->bills->reduce(function ($carry, $bill) {
                    $dueDate = \Carbon\Carbon::parse($bill->due_date);
                    $today = \Carbon\Carbon::now();
                    if ($bill->status !== 'paid' && $dueDate->lessThan($today)) {
                        $carry += $dueDate->diffInDays($today);
                    }
                    return $carry;
                }, 0);
                return $user;
            });

        return view('Admin.Admin_Bills.admin_bills', compact('users'));
    }

    public function showUserBills($userId)
    {
        $user = User::with(['bills.payment'])->findOrFail($userId);
        $bills = $user->bills; // หรือสามารถใช้ $user->bills ถ้าต้องการใช้ข้อมูลนี้ใน view

        return view('Admin.Admin_Bills.admin_show_user_bills', compact('user', 'bills'));
    }
}
