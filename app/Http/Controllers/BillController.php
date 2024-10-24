<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bill;
use Illuminate\Support\Facades\Auth;
use App\Models\Payment;

class BillController extends Controller
{
    public function showBillindex()
    {
        $user = Auth::user();

        $bills = Bill::with('user')->where('user_id', $user->id)->get();

        return view('User.User_Bills.user_bills', compact('bills'));
    }

    public function pay(Request $request, $bill_id)
    {
        // Validate input data
        $request->validate([
            'payment_date' => 'required|date',
            'amount_paid' => 'required|numeric|min:0',
            'payment_receipt' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // ดึงข้อมูลบิลจากฐานข้อมูล
        $bill = Bill::findOrFail($bill_id);

        // จัดการกับไฟล์รูปภาพใบเสร็จ
        $receiptPath = $request->file('payment_receipt')->store('receipts', 'public');

        // บันทึกข้อมูลการชำระเงินในตาราง payments
        Payment::create([
            'bill_id' => $bill->bill_id,
            'payment_date' => $request->payment_date,
            'amount_paid' => $request->amount_paid,
            'payment_receipt' => $receiptPath,
        ]);

        // อัปเดตสถานะบิลเป็น 'pending'
        $bill->update(['status' => 'pending']);

        // Redirect กลับไปยังหน้าเดิม
        return redirect()->back()->with('success', 'บันทึกการชำระเงินเรียบร้อยแล้ว.');
    }
}
