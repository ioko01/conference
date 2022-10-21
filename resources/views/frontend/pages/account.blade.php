@extends('frontend.layouts.master_frontend')

@section('content')
    <div id="account-content" class="row my-5">
        <div class="col-md-6 mx-auto">
            <div class="card">
                <div class="card-content">
                    <div class="card-header bg-green rounded-0">
                        <strong>
                            <i class="nav-icon fas fa-user"></i> รายละเอียดผู้ใช้งาน
                        </strong>
                    </div>
                    <div class="card-body">
                        @if ($user->is_admin == 2)
                            <p>
                                <strong>สถานะ <span class="text-green">ซุปเปอร์แอดมิน</span></strong>
                            </p>
                        @else
                            <div class="row">
                                <div class="col-md-3">
                                    <p>
                                        <strong>สถานะ
                                            <span class="text-green">
                                                @if ($user->is_admin == 0)
                                                    ผู้ใช้งานทั่วไป
                                                @elseif($user->is_admin == 1)
                                                    แอดมิน
                                                @endif
                                            </span>
                                        </strong>
                                    </p>
                                </div>
                            </div>
                        @endif


                        <div class="row">
                            <div class="col-md-12">
                                <p>
                                    <strong>อีเมล <span class="text-green">{{ $user->email }}</span></strong>
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <p>
                                    <strong>รหัสผ่าน
                                        @if (auth()->user()->id == $user->id)
                                            <a style="text-decoration: underline;"
                                                href="{{ route('user.change_password') }}"><i
                                                    class="nav-icon fa fa-pen"></i>
                                                เปลี่ยนรหัสผ่าน</a>
                                        @else
                                        @endif
                                    </strong>
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                @if ($user->person_attend === 'send')
                                    <p class="d-block">
                                        <strong>การลงทะเบียน <span class="text-green">ลงทะเบียนส่งผลงาน</span></strong>
                                    </p>
                                @elseif($user->person_attend === 'attend')
                                    <p class="d-block">
                                        <strong>การลงทะเบียน <span
                                                class="text-green">ลงทะเบียนเข้าร่วมงานทั่วไป</span></strong>
                                    </p>
                                @endif
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-md-6">
                                <p><strong>ชื่อ-สกุล <span
                                            class="text-green">{{ $user->prefix }}{{ $user->fullname }}</span></strong></p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <p class="d-block">
                                    <strong>เพศ
                                        <span class="text-green">
                                            @if ($user->sex === 'male')
                                                ชาย
                                            @elseif($user->sex === 'female')
                                                หญิง
                                            @endif
                                        </span>
                                    </strong>
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <p>
                                    <strong>
                                        เบอร์โทร
                                        <span class="text-green">
                                            {{ $user->phone }}
                                        </span>
                                    </strong>
                                </p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                @foreach ($positions as $position)
                                    @if ($user->position_id == $position->id)
                                        <p>
                                            <strong>
                                                สถานะ
                                                <span class="text-green">{{ $position->name }}</span>
                                            </strong>
                                        </p>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <p>
                                    <strong>
                                        สังกัด / หน่วยงาน
                                        <span class="text-green">
                                            {{ $user->institution }}
                                        </span>
                                    </strong>
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                @if ($user->position_id != '3')
                                    <p>
                                        <strong>
                                            โควต้าเจ้าภาพร่วม
                                            <span>-</span>
                                        </strong>
                                    </p>
                                @else
                                    @foreach ($kotas as $kota)
                                        @if ($user->kota_id == $kota->id)
                                            <p>
                                                <strong>
                                                    โควต้าเจ้าภาพร่วม
                                                    <span class="text-green">{{ $kota->name }}</span>
                                                </strong>
                                            </p>
                                        @endif
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <p>
                                    <strong>
                                        ที่อยู่
                                        @if ($user->address)
                                            <span class="text-green">
                                                {{ $user->address }}
                                            </span>
                                        @else
                                            <span>-</span>
                                        @endif
                                    </strong>
                                </p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <p>
                                    <strong>
                                        ความต้องการใบเสร็จรับเงิน
                                        @if ($user->check_requirement)
                                            <span class="text-green">
                                                @if ($user->check_requirement === 'after')
                                                    ต้องการใบเสร็จรับเงิน <span class="fw-bold text-red">"หลัง"</span>
                                                    วันจัดประชุม
                                                @elseif($user->check_requirement === 'before')
                                                    ต้องการใบเสร็จรับเงิน <span class="fw-bold text-red">"ก่อน"</span>
                                                    วันจัดประชุม
                                                @endif
                                            </span>
                                        @else
                                            <span>
                                                -
                                            </span>
                                        @endif

                                    </strong>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
