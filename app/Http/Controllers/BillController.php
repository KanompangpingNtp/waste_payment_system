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

    // public function pay(Request $request, $bill_id)
    // {
    //     $request->validate([
    //         'payment_date' => 'required|date',
    //         'amount_paid' => 'required|numeric|min:0',
    //         'payment_receipt' => 'required|image|mimes:jpeg,png,jpg|max:2048',
    //     ]);

    //     $bill = Bill::findOrFail($bill_id);

    //     $receiptPath = $request->file('payment_receipt')->store('receipts', 'public');

    //     Payment::create([
    //         'bill_id' => $bill->bill_id,
    //         'payment_date' => $request->payment_date,
    //         'amount_paid' => $request->amount_paid,
    //         'payment_receipt' => $receiptPath,
    //     ]);

    //     $bill->update(['status' => 'pending']);

    //     return redirect()->back()->with('success', 'บันทึกการชำระเงินเรียบร้อยแล้ว.');
    // }
    public function pay(Request $request, $bill_id)
{
    $request->validate([
        'payment_date' => 'required|date',
        'amount_paid' => 'required|numeric|min:0',
        'payment_receipt' => 'required|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    $bill = Bill::findOrFail($bill_id);

    // กำหนดชื่อไฟล์ใหม่ให้ไม่ซ้ำ
    $filename = time() . '_' . $request->file('payment_receipt')->getClientOriginalName();

    // ย้ายไฟล์ไปที่โฟลเดอร์ public/storage/receipts
    $request->file('payment_receipt')->move(public_path('storage/receipts'), $filename);

    // สร้างเส้นทางที่ใช้เก็บไฟล์
    $receiptPath = 'storage/receipts/' . $filename;

    // สร้างรายการการชำระเงินใหม่
    Payment::create([
        'bill_id' => $bill->bill_id,
        'payment_date' => $request->payment_date,
        'amount_paid' => $request->amount_paid,
        'payment_receipt' => $receiptPath,
    ]);

    // อัปเดตสถานะของบิลเป็น 'pending'
    $bill->update(['status' => 'pending']);

    // กลับไปยังหน้าก่อนหน้าพร้อมแสดงข้อความสำเร็จ
    return redirect()->back()->with('success', 'บันทึกการชำระเงินเรียบร้อยแล้ว.');
}

}
