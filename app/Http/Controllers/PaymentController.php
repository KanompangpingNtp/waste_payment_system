<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bill;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function showPaidBills()
    {
        // ดึงข้อมูลบิลของผู้ใช้ที่ล็อกอินอยู่ และสถานะเป็น 'paid'
        $userId = Auth::id(); // ดึง user_id ของผู้ใช้ที่ล็อกอินอยู่
        $paidBills = Bill::where('user_id', $userId)
            ->where('status', 'paid')
            ->with(['user', 'payment'])
            ->get();

        return view('User.User_Payment.user_payment', compact('paidBills'));
    }
}
