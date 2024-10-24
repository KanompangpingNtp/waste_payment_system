<!-- resources/views/user_index.blade.php -->

<!DOCTYPE html>
<html>

<head>
    <title>รายการที่ชำระเงินแล้ว</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.6/css/dataTables.dataTables.css" />
</head>

@php
    use Carbon\Carbon;
@endphp

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mt-5">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span><h4>ระบบชำระค่าธรรมเนียมขยะ</h4></span>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger">ออกจากระบบ</button>
                        </form>
                    </div>

                    <div class="card-body">
                        <a href="{{ route('showUserindex') }}" class="btn btn-primary" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">กลับหน้าหลัก</a><br><br>

                            <h5 class="text-center">รายการที่ชำระเงินแล้ว</h5><br>
                        <table class="table table-bordered">
                            <thead>
                                <tr class="text-center">
                                    <th>ผู้ใช้</th>
                                    <th>เดือนที่เรียกเก็บเงิน</th>
                                    <th>จำนวน</th>
                                    <th>กำหนดชำระ</th>
                                    <th>วันที่ชำระเงิน</th>
                                    <th>สถานะ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($paidBills as $bill)
                                    <tr class="text-center">
                                        <td>{{ $bill->user->name ?? 'N/A' }}</td>
                                        <td data-date="{{ $bill->billing_month }}">{{ $bill->billing_month }}</td>
                                        <td>{{ number_format($bill->amount, 2) }}</td>
                                        <td data-date="{{ $bill->due_date }}">{{ $bill->due_date }}</td>
                                        <td data-date="{{ $bill->payment ? $bill->payment->payment_date : '' }}">
                                            {{ $bill->payment ? $bill->payment->payment_date : 'N/A' }}
                                        </td>
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
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{asset('js/datethai.js')}}"></script>
</body>

</html>
