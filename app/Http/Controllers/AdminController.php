<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Bill;

class AdminController extends Controller
{
    //
    // public function showAdminindex()
    // {
    //     $totalUsers = User::count();

    //     $usersWithUnpaidBills = User::whereHas('bills', function ($query) {
    //         $query->where('status', 'unpaid');
    //     })->count();

    //     $pendingBills = Bill::where('status', 'pending')->count();

    //     $totalBills = Bill::count();
    //     $pendingBillsPercentage = $totalBills > 0 ? ($pendingBills / $totalBills) * 100 : 0;

    //     return view('Admin.admin_index', compact('totalUsers', 'usersWithUnpaidBills', 'pendingBills', 'pendingBillsPercentage'));
    // }
    public function showAdminindex()
    {
        $totalUsers = User::count();

        // คำนวณจำนวนผู้ใช้ที่มีบิลค้างชำระ
        $usersWithUnpaidBills = User::whereHas('bills', function ($query) {
            $query->whereIn('status', ['pending', 'unpaid']); // รวมทั้งสถานะ pending และ unpaid
        })->count();

        $pendingBills = Bill::where('status', 'pending')->count();
        $totalBills = Bill::count();
        $pendingBillsPercentage = $totalBills > 0 ? ($pendingBills / $totalBills) * 100 : 0;

        return view('Admin.admin_index', compact('totalUsers', 'usersWithUnpaidBills', 'pendingBills', 'pendingBillsPercentage'));
    }
}
