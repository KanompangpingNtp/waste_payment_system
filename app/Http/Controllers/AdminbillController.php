<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bill;
use App\Models\Payment;
use App\Models\User;

class AdminbillController extends Controller
{
    public function showAdminBills()
    {
        // ดึงบิลทั้งหมดพร้อมข้อมูลผู้ใช้และการชำระเงิน
        // $bills = Bill::with('user', 'payment')->get();
        $bills = Bill::with('user', 'payment')->orderBy('created_at', 'desc')->get();

        // ดึงผู้ใช้ทั้งหมดที่เป็น level user (ไม่ใช่ admin)
        $users = User::where('level', 'user')->get();

        return view('Admin.Admin_Bills.admin_manage_bills', compact('bills', 'users'));
    }

    // public function EditAdminBills(Request $request, $id)
    // {
    //     // ตรวจสอบข้อมูลจากฟอร์ม
    //     $request->validate([
    //         'billing_month' => 'required|date',
    //         'amount' => 'required|numeric',
    //         'due_date' => 'required|date',
    //         'status' => 'required|in:paid,unpaid,pending',
    //     ]);

    //     // ค้นหาบิลที่ต้องการแก้ไข
    //     $bill = Bill::findOrFail($id);

    //     // อัปเดตข้อมูลบิล
    //     $bill->billing_month = $request->billing_month;
    //     $bill->amount = $request->amount;
    //     $bill->due_date = $request->due_date;
    //     $bill->status = $request->status;
    //     $bill->save();

    //     // กลับไปยังหน้าแสดงบิลทั้งหมด พร้อมแสดงข้อความสำเร็จ
    //     return redirect()->back()->with('success', 'อัปเดตบิลเรียบร้อยแล้ว');
    // }
    public function EditAdminBills(Request $request, $id)
    {
        // ตรวจสอบข้อมูลจากฟอร์ม
        $request->validate([
            'billing_month' => 'required|date',
            'amount' => 'required|numeric',
            'due_date' => 'required|date',
            'status' => 'required|in:paid,unpaid,pending',
        ]);

        // ค้นหาบิลที่ต้องการแก้ไข
        $bill = Bill::findOrFail($id);

        // อัปเดตข้อมูลบิล
        $bill->billing_month = $request->billing_month;
        $bill->amount = $request->amount;
        $bill->due_date = $request->due_date;
        $bill->status = $request->status;
        $bill->save();

        // ถ้าสถานะเป็น 'unpaid' ให้ลบข้อมูลการชำระเงินที่เกี่ยวข้อง
        if ($bill->status === 'unpaid') {
            $bill->payment_bill()->delete(); // ใช้ชื่อฟังก์ชันที่คุณกำหนดไว้
        }

        // กลับไปยังหน้าแสดงบิลทั้งหมด พร้อมแสดงข้อความสำเร็จ
        return redirect()->back()->with('success', 'อัปเดตบิลเรียบร้อยแล้ว');
    }


    public function EditAdminDelete($id)
    {
        // ค้นหาบิลที่ต้องการลบ
        $bill = Bill::findOrFail($id);
        // ลบการชำระเงินที่เกี่ยวข้อง
        Payment::where('bill_id', $id)->delete();
        // ลบบิล
        $bill->delete();

        // กลับไปยังหน้าแสดงบิลทั้งหมด พร้อมแสดงข้อความสำเร็จ
        return redirect()->back()->with('success', 'ลบบิลสำเร็จแล้ว');
    }

    public function AdminbillsCreate(Request $request)
    {
        // Validate the input data
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'billing_month' => 'required|date_format:Y-m', // ตรวจสอบรูปแบบ 'YYYY-MM'
            'amount' => 'required|numeric|min:0',
            'due_date' => 'required|date',
            'status' => 'required|in:unpaid,pending,paid',
        ]);

        // แปลงค่าของ billing_month ให้อยู่ในรูปแบบ 'YYYY-MM-01'
        $billingMonth = $request->billing_month . '-01';

        // Create a new bill
        Bill::create([
            'user_id' => $request->user_id,
            'billing_month' => $billingMonth,
            'amount' => $request->amount,
            'due_date' => $request->due_date,
            'status' => $request->status,
        ]);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'สร้างบิลสำเร็จแล้ว');
    }

    public function showApproveBills()
    {
        // ดึงข้อมูลบิลที่มีสถานะ 'unpaid' และ 'paid'
        $bills = Bill::with('user') // ดึงข้อมูลผู้ใช้ที่เกี่ยวข้อง
            ->whereIn('status', ['pending'])
            ->orderBy('created_at', 'desc') // จัดเรียงจากใหม่ไปเก่า
            ->get();

        return view('Admin.Admin_Bills.admin_approve_bills', compact('bills'));
    }

    public function approveBill($bill_id)
    {
        // ค้นหาบิลตาม ID
        $bill = Bill::findOrFail($bill_id);

        // เปลี่ยนสถานะบิลเป็น 'paid'
        $bill->status = 'paid';
        $bill->save();

        return redirect()->back()->with('success', 'บิลได้รับการอนุมัติแล้ว');
    }

    public function deleteBill($bill_id)
    {
        // ค้นหาบิลตาม ID
        $bill = Bill::findOrFail($bill_id);

        // เปลี่ยนสถานะบิลเป็น 'unpaid'
        $bill->status = 'unpaid';
        $bill->save();

        // ลบข้อมูลในตาราง payments ที่เกี่ยวข้องกับบิลนี้
        Payment::where('bill_id', $bill_id)->delete();

        return redirect()->back()->with('success', 'บิลถูกเปลี่ยนสถานะเป็นยังไม่ได้จ่ายและลบข้อมูลการชำระเงินเรียบร้อยแล้ว');
    }
}
