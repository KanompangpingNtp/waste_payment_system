<!-- resources/views/user_index.blade.php -->

<!DOCTYPE html>
<html>

<head>
    <title>รายการที่ต้องชำระ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    @php
        use Carbon\Carbon;
    @endphp
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mt-5">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>
                            <h4>ระบบชำระค่าธรรมเนียมขยะ</h4>
                        </span>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger">ออกจากระบบ</button>
                        </form>
                    </div>

                    <div class="card-body">
                        @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                        @endif

                        <div class="mt-3">
                            <a href="{{ route('showUserindex') }}" class="btn btn-primary" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">กลับหน้าหลัก</a><br><br>

                            <h5 class="text-center">รายการที่ต้องชำระ</h5><br>
                            {{-- <p><strong>ที่อยู่ :</strong> {{ Auth::user()->address }}</p> --}}
                        </div>

                        <div>
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="text-center">
                                        {{-- <th>ลำดับ</th> --}}
                                        <th>เดือนที่เรียกเก็บเงิน</th>
                                        <th>จำนวน</th>
                                        <th>กำหนดจ่าย</th>
                                        <th>สถานะ</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                {{-- <tbody class="text-center">
                                    @foreach ($bills as $bill)
                                    <tr>
                                        <td>{{ $bill->bill_id }}</td>
                                        <td data-date="{{ $bill->billing_month }}">{{ $bill->billing_month }}</td>
                                        <td>{{ number_format($bill->amount, 2) }}</td>
                                        <td data-date="{{ $bill->due_date }}">{{ $bill->due_date }}</td>
                                        <td>
                                            @if($bill->status == 'pending')
                                            <span class="text-warning">รอดำเนินการ</span>
                                            @elseif($bill->status == 'paid')
                                            <span class="text-success">จ่ายบิลแล้ว</span>
                                            @elseif($bill->status == 'unpaid')
                                            <span class="text-danger">ยังไม่ได้จ่ายบิล</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($bill->status === 'pending' || $bill->status === 'paid')
                                            <a class="btn btn-warning btn-sm disabled">
                                                ชำระเงิน
                                            </a>
                                            @else
                                            <a class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="{{ '#payment_' . $bill->bill_id }}">
                                                ชำระเงิน
                                            </a>
                                            @endif

                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody> --}}
                                <tbody class="text-center">
                                    @foreach ($bills as $bill)
                                        @if ($bill->status === 'paid')
                                            @continue
                                        @endif
                                        <tr>
                                            {{-- <td>{{ $bill->bill_id }}</td> --}}
                                            {{-- <td>{{ $bill->user->name }}</td> --}}
                                            <td data-date="{{ $bill->billing_month }}">{{ $bill->billing_month }}</td>
                                            <td>{{ number_format($bill->amount, 2) }}</td>
                                            <td data-date="{{ $bill->due_date }}">{{ $bill->due_date }}</td>
                                            <td>
                                                @if($bill->status == 'pending')
                                                    <span class="text-warning">รอดำเนินการ</span>
                                                @elseif($bill->status == 'unpaid')
                                                    <span class="text-danger">ยังไม่ได้จ่ายบิล</span>
                                                @else
                                                    {{-- <span class="text-secondary">{{ ucfirst($bill->status) }}</span> --}}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($bill->status === 'pending')
                                                    <a class="btn btn-success btn-sm disabled">
                                                        ชำระเงินแล้ว
                                                    </a>
                                                @else
                                                    <a class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="{{ '#payment_' . $bill->bill_id }}">
                                                        ชำระเงิน
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>

                        <!-- Modal Edit -->
                        @foreach ($bills as $bill)
                        <div class="modal fade" id="{{ 'payment_' . $bill->bill_id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="{{ 'payment_' . $bill->bill_id }}">ฟอร์มการชำระเงิน</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- ฟอร์มการชำระเงิน -->
                                        <form action="{{ route('bills.pay', $bill->bill_id) }}" method="POST" enctype="multipart/form-data">
                                            @csrf

                                            <?php
                                                $today = date('Y-m-d'); // วันที่ปัจจุบันในรูปแบบ YYYY-MM-DD
                                            ?>

                                            <div class="mb-3">
                                                <label for="payment_date" class="form-label">วันที่ชำระเงิน</label>
                                                <input type="date" class="form-control" name="payment_date" id="payment_date" value="<?php echo $today; ?>" required readonly>
                                            </div>
                                            <div class="mb-3">
                                                <label for="amount_paid" class="form-label">จำนวนเงินที่ชำระ</label>
                                                <input type="number" step="0.01" class="form-control" name="amount_paid" value="{{ number_format($bill->amount, 2) }}" required readonly>
                                            </div>
                                            <div class="mb-3">
                                                <label for="payment_receipt" class="form-label">ใบเสร็จการโอนเงิน</label>
                                                <input type="file" class="form-control" name="payment_receipt" accept="image/*" required>
                                            </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                                        <button type="submit" class="btn btn-primary">ยืนยัน</button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        <!-- End Modal Edit -->

                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{asset('js/datethai.js')}}"></script>

</body>

</html>
