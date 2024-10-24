@extends('Admin.Admin_Layout.admin_layout')
@section('admin_layout')

<br>

<title>รายละเอียดบิลของผู้ใช้</title>

<div class="container">

    <h2>รายละเอียดบิลของผู้ใช้</h2> <br>

    <table class="table table-bordered">
        <thead>
            <tr class="text-center">
                <th>ผู้ใช้</th>
                <th>เบอร์มือถือ</th>
                <th>ที่อยู่</th>
                <th>ยอดเงินคงค้างรวม</th>
                <th>จำนวนวันที่ค้างชำระ</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr class="text-center">
                <td class="text-center">
                    <a href="{{ route('showUserBills', $user->id) }}">{{ $user->name }}</a>
                </td>
                <td>{{ $user->phone_number }}</td>
                <td class="text-start">{{ $user->address }}</td>
                <td>
                    @if($user->total_due == 0)
                        <p>ไม่มียอดเงินติดค้าง</p>
                    @else
                        <p class="text-danger">{{ $user->total_due }} บาท</p>
                    @endif
                </td>
                <td>
                    @if($user->total_overdue_days == 0)
                        <p>ไม่มีการค้างชำระ</p>
                    @else
                        <p class="text-danger">{{ $user->total_overdue_days }} วัน</p>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>




</div>

@endsection
