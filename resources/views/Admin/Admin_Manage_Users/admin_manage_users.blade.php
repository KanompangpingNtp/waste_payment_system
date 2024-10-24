@extends('Admin.Admin_Layout.admin_layout')
@section('admin_layout')

<br>

<div class="container">
    <h2>การจัดการผู้ใช้</h2><br>

    {{-- @if ($message = Session::get('success'))
    <script>
        Swal.fire({
            icon: 'success'
            , title: '{{ $message }}'
    , })

    </script>
    @endif --}}
    @if ($message = Session::get('success'))
    <script>
        Swal.fire({
            icon: 'success'
            , title: '{{ $message }}'
        , })

    </script>
    @endif

    @if ($message = Session::get('error'))
    <script>
        Swal.fire({
            icon: 'error'
            , title: '{{ $message }}'
        , })

    </script>
    @endif



    <!-- ปุ่มสร้างผู้ใช้ใหม่ -->
    <button type="button" class="btn btn-primary mb-3 btn-sm" data-bs-toggle="modal" data-bs-target="#createUserModal">
        เพิ่มผู้ใช้งานใหม่
    </button>
    <br>

    <!-- ตารางแสดงข้อมูลผู้ใช้ -->
    <table class="table table-bordered">
        <thead>
            <tr class="text-center">
                <th>ชื่อ</th>
                {{-- <th>ชื่อผู้ใช้</th> --}}
                <th>เบอร์ติดต่อ</th>
                <th>ที่อยู่</th>
                <th>ระดับผู้ใช้งาน</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr class="text-center">
                <td class="text-start">{{ $user->name }}</td>
                {{-- <td>{{ $user->username }}</td> --}}
                <td class="text-start">{{ $user->phone_number }}</td>
                <td class="text-start">{{ $user->address }}</td>
                {{-- <td>{{ ucfirst($user->level) }}</td> --}}
                <td>
                    @if ($user->level === 'user')
                        <p>ผู้ใช้งานทั่วไป</p>
                    @elseif ($user->level === 'admin')
                        <p>ผู้ดูแลระบบ</p>
                    @endif
                </td>
                <td>
                    <!-- ปุ่มแก้ไข -->
                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editUserModal{{ $user->id }}">แก้ไขข้อมูลผู้ใช้</button>

                    <!-- ฟอร์มลบผู้ใช้ -->
                    <form action="{{ route('deleteUser', $user->id) }}" method="post" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">ลบผู้ใช้</button>
                    </form>
                </td>
            </tr>

            <!-- Modal แก้ไขผู้ใช้ -->
            <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('editUser', $user->id) }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="modal-header">
                                <h5 class="modal-title">แก้ไขผู้ใช้งาน</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="name" class="form-label">ชื่อ</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="username" class="form-label">ชื่อนาม</label>
                                    <input type="text" class="form-control" id="username" name="username" value="{{ $user->username }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="phone_number" class="form-label">เบอร์ติดต่อ</label>
                                    <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{ $user->phone_number }}">
                                </div>
                                <div class="mb-3">
                                    <label for="address" class="form-label">ที่อยู่</label>
                                    <input type="text" class="form-control" id="address" name="address" value="{{ $user->address }}">
                                </div>
                                <div class="mb-3">
                                    <label for="level" class="form-label">ระดับผู้ใช้งาน</label>
                                    <select class="form-select" id="level" name="level" required>
                                        <option value="user" {{ $user->level == 'user' ? 'selected' : '' }}>User</option>
                                        <option value="admin" {{ $user->level == 'admin' ? 'selected' : '' }}>Admin</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">รหัสผ่านใหม่ (ถ้าไม่ต้องการเปลี่ยนปล่อยว่างไว้)</label>
                                    <input type="password" class="form-control" id="password" name="password">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                                <button type="submit" class="btn btn-primary">บันทึกการแก้ไข</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
            @endforeach
        </tbody>
    </table>

    <!-- Modal สร้างผู้ใช้ -->
    <div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('createUser') }}" method="post">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">สร้างผู้ใช้งานใหม่</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">ชื่อ</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">ชื่อนาม</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone_number" class="form-label">เบอร์ติดต่อ</label>
                            <input type="text" class="form-control" id="phone_number" name="phone_number">
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">ที่อยู่</label>
                            <input type="text" class="form-control" id="address" name="address">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">รหัสผ่าน</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="level" class="form-label">ระดับผู้ใช้งาน</label>
                            <select class="form-select" id="level" name="level" required>
                                <option value="user">ผู้ใช้งานทั่วไป</option>
                                <option value="admin">ผู้ดูแลระบบ</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                        <button type="submit" class="btn btn-primary">สร้างผู้ใช้งาน</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
