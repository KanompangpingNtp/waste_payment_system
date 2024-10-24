<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Bill;
use Carbon\Carbon;

class GenerateMonthlyBills extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:monthly-bills';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate monthly bills for all users on the 1st of every month';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        // รับวันที่ 1 ของเดือนปัจจุบัน
        // $currentMonth = Carbon::now()->startOfMonth();

        // // รับผู้ใช้ทั้งหมดจากตาราง users
        // $users = User::all();

        // foreach ($users as $user) {
        //     // สร้างบิลใหม่สำหรับผู้ใช้แต่ละคน
        //     Bill::create([
        //         'user_id' => $user->id,
        //         'billing_month' => $currentMonth,
        //         'amount' => 30.00,
        //         'due_date' => $currentMonth->copy()->endOfMonth(), // วันที่ครบกำหนดชำระเป็นวันสุดท้ายของเดือน
        //         'status' => 'unpaid',
        //     ]);
        // }

        // $this->info('Monthly bills have been generated successfully.');
        // รับวันที่ 1 ของเดือนปัจจุบัน
        $currentMonth = Carbon::now()->startOfMonth();

           // รับผู้ใช้ทั้งหมดจากตาราง users
          // $users = User::all();
         // รับผู้ใช้ทั้งหมดจากตาราง users ที่มี level = 'user'
        $users = User::where('level', 'user')->get();

        foreach ($users as $user) {
            // ตรวจสอบว่ามีบิลของผู้ใช้ในเดือนปัจจุบันแล้วหรือไม่
            $existingBill = Bill::where('user_id', $user->id)
                                ->where('billing_month', $currentMonth)
                                ->first();

            // ถ้ายังไม่มีบิลในเดือนปัจจุบัน จึงจะสร้างบิลใหม่
            if (!$existingBill) {
                Bill::create([
                    'user_id' => $user->id,
                    'billing_month' => $currentMonth,
                    'amount' => 30.00,
                    'due_date' => $currentMonth->copy()->endOfMonth(), // วันที่ครบกำหนดชำระเป็นวันสุดท้ายของเดือน
                    'status' => 'unpaid',
                ]);
            }
        }

        $this->info('Monthly bills have been generated successfully.');
    }
}
