<!-- resources/views/user_index.blade.php -->

<!DOCTYPE html>
<html>

<head>
    <title>หน้าหลัก</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

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
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                    <div class="mt-3">
                        <h4>ข้อมูลผู้ใช้</h4><br>
                        <p class="mt-3"><strong>ชื่อ :</strong> {{ Auth::user()->name }}</p>
                        <p><strong>เบอร์ติดต่อ :</strong> {{ Auth::user()->phone_number }}</p>
                        <p><strong>ที่อยู่ :</strong> {{ Auth::user()->address }}</p>
                    </div>
                    <br>
                    <br>
                    <div>
                        <a href="{{route('showBillindex')}}" class="btn btn-info"><i class="bi bi-receipt-cutoff"></i> รายการที่ต้องชำระ</a>
                        <a href="{{route('showPaidBills')}}" class="btn btn-info"><i class="bi bi-receipt"></i>  ตรวจสอบรายการที่ชำระ</a>
                    </div>

                        {{-- <ul class="list-group mb-3">
                            <li class="list-group-item"><strong>ชื่อ :</strong> {{ Auth::user()->name }}</li>
                            <li class="list-group-item"><strong>เบอร์มือถือ :</strong> {{ Auth::user()->phone_number }}</li>
                            <li class="list-group-item"><strong>ที่อยู่ :</strong> {{ Auth::user()->address }}</li>
                        </ul> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
