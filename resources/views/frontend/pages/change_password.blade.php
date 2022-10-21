@extends('frontend.layouts.master_frontend')

@section('content')
    <div class="row my-5">
        <div class="col-md-6 mx-auto">
            <div class="card">
                <div class="card-content">
                    <div class="card-header bg-green rounded-0">
                        <strong>
                            <i class="nav-icon fas fa-key"></i> {{ __('เปลี่ยนรหัสผ่าน') }}
                        </strong>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('user.update_password') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="mb-3">
                                    <strong class="text-green">ชื่อ-สกุล: {{ $user->fullname }}</strong><br />
                                    <strong class="text-green">อีเมล: {{ $user->email }}</strong><br />
                                </div>

                                <div class="mb-3">
                                    <label for="oldPasswordInput" class="form-label">รหัสผ่านปัจจุบัน</label>
                                    <input name="old_password" type="password"
                                        class="form-control @error('old_password') is-invalid @enderror"
                                        id="oldPasswordInput" placeholder="รหัสผ่านปัจจุบัน">
                                    @error('old_password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="newPasswordInput" class="form-label">รหัสผ่านใหม่</label>
                                    <input name="new_password" type="password"
                                        class="form-control @error('new_password') is-invalid @enderror"
                                        id="newPasswordInput" placeholder="รหัสผ่านใหม่">
                                    @error('new_password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="confirmNewPasswordInput" class="form-label">ยืนยันรหัสผ่านใหม่</label>
                                    <input name="new_password_confirmation" type="password" class="form-control"
                                        id="confirmNewPasswordInput" placeholder="ยืนยันรหัสผ่านใหม่">
                                </div>

                            </div>

                            <div class="card-footer bg-white">
                                <button class="btn btn-green text-white rounded-0"><i class="fas fa-save"></i>
                                    บันทึก</button>
                                <a style="color: #fff!important;" href="{{ route('account.index') }}"
                                    class="btn btn-secondary rounded-0"><i class="fas fa-times"></i> ยกเลิก</a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
