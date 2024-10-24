@extends('Admin.Admin_Layout.admin_layout')
@section('admin_layout')

<br>

<title>หน้าหลัก</title>

<div class="container">
    <h2>Dashboard</h2><br>
    <div class="row">
        <!-- Total Users Card Example -->
        <div class="col-md-4 mb-4">
            <a href="{{ route('showAdminManageUsers') }}" class="text-decoration-none text-dark">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    จำนวนผู้ใช้งานทั้งหมด
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalUsers }} คน</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Users with Unpaid Bills Card Example -->
        <div class="col-md-4 mb-4">
            <a href="{{ route('showAdminBillindex') }}" class="text-decoration-none text-dark">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    ผู้ใช้ที่มีบิลค้างชำระ
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $usersWithUnpaidBills }} คน</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-exclamation-circle fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>


        <!-- Pending Bills Card Example -->
        <div class="col-md-4 mb-4">
            <a href="{{ route('showApproveBills') }}" class="text-decoration-none text-dark">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    บิลที่รอดำเนินการ
                                </div>
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $pendingBills }} บิล</div>
                                    </div>
                                    <div class="col">
                                        <div class="progress progress-sm mr-2">
                                            <div class="progress-bar bg-info" role="progressbar"
                                                style="width: {{ $pendingBillsPercentage }}%" aria-valuenow="{{ $pendingBillsPercentage }}" aria-valuemin="0"
                                                aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

</div>

@endsection
