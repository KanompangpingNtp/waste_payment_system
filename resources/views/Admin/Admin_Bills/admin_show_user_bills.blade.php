@extends('Admin.Admin_Layout.admin_layout')
@section('admin_layout')

<br>

@if ($message = Session::get('success'))
<script>
    Swal.fire({
        icon: 'success'
        , title: '{{ $message }}'
    , })

</script>
@endif

@php
    use Carbon\Carbon;
@endphp

<title>บิลค่าใช้จ่าย</title>

<div class="container">

    <a href="{{ route('showAdminBillindex') }}" class="btn btn-primary btn-sm" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">กลับหน้าหลัก</a><br><br>

    <h2>บิลค่าใช้จ่ายของ {{ $user->name }}</h2><br>
    <h6>เบอร์มือถือ : {{ $user->phone_number }}</h6>
    <h6>ที่อยู่ : {{ $user->address }}</h6>
    <br>
    <table class="table table-bordered" id="datatablesSimple">
        <thead>
            <tr class="text-center">
                <th>ผู้ใช้</th>
                <th>เดือนที่เรียกเก็บเงิ</th>
                <th>จำนวนเงิน</th>
                <th>วันครบกำหนดชำระ</th>
                <th>สถานะ</th>
                <th>ใบเสร็จรับเงิน</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($bills as $bill)
            <tr class="text-center">
                <td>{{ $user->name }}</td>
                <td data-date="{{ $bill->billing_month }}">{{ $bill->billing_month }}</td>
                <td>{{ $bill->amount }} บาท</td>
                <td data-date="{{ $bill->due_date }}">{{ $bill->due_date }}</td>
                {{-- <td>{{ ucfirst($bill->status) }}</td> --}}
                <td>
                    @if($bill->status == 'pending')
                        <span class="text-warning">รอดำเนินการ</span>
                    @elseif($bill->status == 'paid')
                        <span class="text-success">จ่ายบิลแล้ว</span>
                    @elseif($bill->status == 'unpaid')
                        <span class="text-danger">ยังไม่ได้จ่ายบิล</span>
                    @else
                        {{-- <span class="text-secondary">{{ ucfirst($bill->status) }}</span> --}}
                    @endif
                </td>
                <td>
                    @if($bill->status === 'pending' && $bill->payment)
                    <a href="{{ asset('storage/receipts/' . basename($bill->payment->payment_receipt)) }}" target="_blank">
                        <img src="{{ asset('storage/receipts/' . basename($bill->payment->payment_receipt)) }}" alt="Receipt" style="max-width: 100px; max-height: 100px;">
                    </a>
                    @else
                    <p>No Receipt</p>
                    @endif
                </td>
                <td>
                    <a class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="{{ '#Editbills' . $bill->bill_id }}">แก้ไขบิล</a>
                    <form action="{{ route('EditAdminDelete', $bill->bill_id) }}" method="post" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">ลบบิล</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

     <!-- Modal Edit -->
     @foreach ($bills as $bill)
     <div class="modal fade" id="{{ 'Editbills' . $bill->bill_id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
         <div class="modal-dialog">
             <div class="modal-content">
                 <div class="modal-header">
                     <h5 class="modal-title" id="{{ 'Editbills' . $bill->bill_id }}">แก้ไขข้อมูลบิล</h5>
                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                 </div>
                 <div class="modal-body">
                     <form action="{{ route('EditAdminBills', $bill->bill_id) }}" method="POST">
                         @csrf
                         @method('PUT')
                         <!-- Billing Month -->
                         <div class="mb-3">
                             <label for="billing_month" class="form-label">Billing Month</label>
                             <input type="date" class="form-control" id="billing_month" name="billing_month" value="{{ $bill->billing_month }}" required>
                         </div>
                         <!-- Amount -->
                         <div class="mb-3">
                             <label for="amount" class="form-label">Amount</label>
                             <input type="number" class="form-control" id="amount" name="amount" value="{{ $bill->amount }}" required>
                         </div>
                         <!-- Due Date -->
                         <div class="mb-3">
                             <label for="due_date" class="form-label">Due Date</label>
                             <input type="date" class="form-control" id="due_date" name="due_date" value="{{ $bill->due_date }}" required>
                         </div>
                         <!-- Status -->
                         <div class="mb-3">
                             <label for="status" class="form-label">Status</label>
                             <select class="form-select" id="status" name="status" required>
                                 <option value="paid" {{ $bill->status == 'paid' ? 'selected' : '' }}>จ่ายบิลแล้ว</option>
                                 <option value="unpaid" {{ $bill->status == 'unpaid' ? 'selected' : '' }}>ยังไม่ได้จ่ายบิล</option>
                                 <option value="pending" {{ $bill->status == 'pending' ? 'selected' : '' }}>รอดำเนินการ</option>
                             </select>
                         </div>
                         <!-- ปุ่มบันทึกการเปลี่ยนแปลง -->
                         <div class="modal-footer">
                             <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                             <button type="submit" class="btn btn-primary">บันทึก</button>
                         </div>
                     </form>
                 </div>
             </div>
         </div>
     </div>
     @endforeach
     <!-- End Modal Edit -->

     <script src="{{asset('js/datethai.js')}}"></script>

</div>

@endsection
