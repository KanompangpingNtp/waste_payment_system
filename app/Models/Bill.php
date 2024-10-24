<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'billing_month', 'amount', 'due_date', 'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

     // ระบุว่าชื่อ Primary Key คือ 'bill_id'
     protected $primaryKey = 'bill_id';

     // ปิดการใช้งาน auto incrementing (ถ้าตั้งค่าไว้ใน migration ว่าไม่ใช่ auto increment)
     public $incrementing = true;

     // ระบุประเภทของ Primary Key ว่าเป็น integer
     protected $keyType = 'int';

     public function payment()
    {
        return $this->hasOne(Payment::class, 'bill_id', 'bill_id');
    }

    public function payment_bill()
    {
        return $this->hasOne(Payment::class, 'bill_id');
    }

}
