@extends('Admin.Admin_Layout.admin_layout')
@section('admin_layout')

<br>

<title>อนุมัติบิล</title>

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


<div class="container">

    <h2>อนุมัติบิล</h2> <br>

    <h4>บิลที่รอการอุมัติการชำระเงิน</h4>
    <table class="table table-bordered" id="datatablesSimple">
        <thead>
            <tr class="text-center">
                <th>ผู้ใช้</th>
                <th>เดือนที่เรียกเก็บเงิน</th>
                <th>จำนวนเงิน</th>
                <th>วันครบกำหนดชำระ</th>
                <th>วันที่ชำระบิล</th>
                <th>สถานะ</th>
                <th>ใบเสร็จรับเงิน</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($bills as $bill)
            <tr class="text-center">
                <td>{{ $bill->user->name }}</td>
                <td data-date="{{ $bill->billing_month }}">{{ $bill->billing_month }}</td>
                <td>{{ $bill->amount }} บาท</td>
                <td data-date="{{ $bill->due_date }}">{{ $bill->due_date }}</td>
                <td data-date="{{ $bill->payment ? $bill->payment->payment_date : '' }}">
                    {{ $bill->payment ? $bill->payment->payment_date : 'N/A' }}
                </td>
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
                    <a href="{{ asset('storage/' . $bill->payment->payment_receipt) }}" target="_blank">
                        <img src="{{ asset('storage/' . $bill->payment->payment_receipt) }}" alt="Receipt" style="max-width: 100px; max-height: 100px;">
                    </a>
                    @else
                    <p>No Receipt</p>
                    @endif
                </td>
                {{-- <td>
                    @if($bill->status === 'pending')
                    <form action="{{ route('approveBill', $bill->bill_id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-success btn-sm">อนุมัติ</button>
                    </form>

                    <!-- ปุ่มไม่อนุมัติบิล -->
                    <form action="{{ route('deleteBill', $bill->bill_id) }}" method="post" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">ไม่อนุมัติ</button>
                    </form>
                    @endif
                </td> --}}
                <td>
                    @if($bill->status === 'pending')
                        <div class="d-inline">
                            <!-- ปุ่มอนุมัติบิล -->
                            <form action="{{ route('approveBill', $bill->bill_id) }}" method="post" class="d-inline">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-success btn-sm">อนุมัติ</button>
                            </form>

                            <!-- ปุ่มไม่อนุมัติบิล -->
                            <form action="{{ route('deleteBill', $bill->bill_id) }}" method="post" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-warning btn-sm">ไม่อนุมัติ</button>
                            </form>
                        </div>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <script src="{{asset('js/datethai.js')}}"></script>
</div>

@endsection
