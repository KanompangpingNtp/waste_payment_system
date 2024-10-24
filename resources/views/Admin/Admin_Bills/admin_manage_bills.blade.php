@extends('Admin.Admin_Layout.admin_layout')
@section('admin_layout')

<br>

<div class="container">
    <h2>Manage Bills</h2> <br>

    @if ($message = Session::get('success'))
    <script>
        Swal.fire({
            icon: 'success'
            , title: '{{ $message }}'
        , })

    </script>
    @endif

    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#CreateBills">
        Create
    </button>
    <br>
    <br>

    <!-- Modal Create -->
    <div class="modal fade" id="CreateBills" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Create New Bill</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form for creating a new bill -->
                    <form action="{{ route('AdminbillsCreate') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="user_id" class="form-label">User</label>
                            <select class="form-select" id="user_id" name="user_id" required>
                                @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="billing_month" class="form-label">Billing Month</label>
                            <input type="month" class="form-control" id="billing_month" name="billing_month" required>
                        </div>
                        <div class="mb-3">
                            <label for="amount" class="form-label">Amount</label>
                            <input type="number" class="form-control" id="amount" name="amount" step="0.01" required>
                        </div>
                        <div class="mb-3">
                            <label for="due_date" class="form-label">Due Date</label>
                            <input type="date" class="form-control" id="due_date" name="due_date" required>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="unpaid">Unpaid</option>
                                <option value="pending">Pending</option>
                                <option value="paid">Paid</option>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal Create -->

    <table class="table table-bordered" id="datatablesSimple">
        <thead>
            <tr class="text-center">
                <th>User</th>
                <th>Billing Month</th>
                <th>Amount</th>
                <th>Due Date</th>
                <th>Status</th>
                <th>Payment Receipt</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($bills as $bill)
            <tr class="text-center">
                <td>{{ $bill->user->name }}</td>
                <td>{{ $bill->billing_month }}</td>
                <td>{{ $bill->amount }}</td>
                <td>{{ $bill->due_date }}</td>
                <td>{{ ucfirst($bill->status) }}</td>
                <td>
                    @if($bill->payment)
                    <a href="{{ asset('storage/' . $bill->payment->payment_receipt) }}" target="_blank">
                        <img src="{{ asset('storage/' . $bill->payment->payment_receipt) }}" alt="Receipt" style="max-width: 100px; max-height: 100px;">
                    </a>
                    @else
                    No Receipt
                    @endif
                </td>
                <td>
                    <a class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="{{ '#Editbills' . $bill->bill_id }}">Edit</a>
                    <form action="{{ route('EditAdminDelete', $bill->bill_id) }}" method="post" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
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
                                <option value="paid" {{ $bill->status == 'paid' ? 'selected' : '' }}>Paid</option>
                                <option value="unpaid" {{ $bill->status == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                                <option value="pending" {{ $bill->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            </select>
                        </div>
                        <!-- ปุ่มบันทึกการเปลี่ยนแปลง -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                            <button type="submit" class="btn btn-primary">Update Bill</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    <!-- End Modal Edit -->

</div>

@endsection
