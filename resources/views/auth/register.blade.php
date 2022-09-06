@extends('frontend.layouts.master_frontend')

@section('content')
    <!-- Content -->
    <div id="register-content" class="bg-white text-blue p-5 my-5">
        <div class="inner-content-header">
            <h4 class="text-center">ลงทะเบียนส่งผลงาน / เข้าร่วมงาน</h4>
            <h4 class="text-green py-3">
                LRU Conference 2022
            </h4>
        </div>
        @if (isset($conference_id->id))
            <div class="row w-100">
                <div class="col-md-7">
                    <form action="{{ route('register') }}" method="POST">
                        @csrf
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="prefix">คำนำหน้า <span style="font-size: 12px;"
                                        class="text-bluesky">(ใช้ลงในเกียรติบัตร)</span></label>
                                <input type="text" name="prefix" id="prefix"
                                    class="form-control @error('prefix') is-invalid @enderror" value="{{ old('prefix') }}"
                                    autocomplete="prefix" autofocus>

                                @error('prefix')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="fullname">ชื่อ - สกุล</label>
                                <input type="text" name="fullname" id="fullname"
                                    class="form-control @error('fullname') is-invalid @enderror"
                                    value="{{ old('fullname') }} " autocomplete="fullname">

                                @error('fullname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="d-block">เพศ</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="sex" id="male"
                                        @if (old('sex') === 'male' || empty(old('sex'))) checked @endif value="male">
                                    <label class="form-check-label" for="male">
                                        ชาย
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="sex" id="female"
                                        @if (old('sex') === 'female') checked @endif value="female">
                                    <label class="form-check-label" for="female">
                                        หญิง
                                    </label>
                                </div>

                                @error('sex')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="phone">เบอร์โทร <i class="text-red">* ใส่ตัวเลข 10 หลักโดยไม่ต้องใส่
                                        "-"</i></label>
                                <input type="tel" name="phone" id="phone"
                                    class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }} "
                                    autocomplete="phone">

                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-12">
                                <label>เลือกสถานะของท่าน
                                    @error('position_id')
                                        <span class="text-danger"> *กรุณาเลือกสถานะของท่าน</span>
                                    @enderror
                                </label>

                                @foreach ($positions as $position)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="position_id"
                                            id="position_{{ $position->id }}" value="{{ $position->id }}"
                                            onchange="toggle_position(this)"
                                            @if (!old('position_id')) @if ($position->id == $positions->first()->id)
                                        checked @endif
                                        @elseif(old('position_id') == $position->id) checked @endif>

                                        <label class="form-check-label" for="position_{{ $position->id }}">
                                            {{ $position->name }}
                                        </label>
                                    </div>
                                @endforeach

                                <p style="color:red">* โควต้าเจ้าภาพร่วมกรุณาติดต่อต้นสังกัด
                                    หากท่านเป็นบุคลากรภายในมหาวิทยาลัยราชภัฏเลย และบทความของท่านเป็นของมหาวิทยาลัยอื่น
                                    จะต้องลงทะเบียนเป็น "บุคคลภายนอก"
                                </p>

                                <div class="row mb-4">
                                    <div class="col-12">
                                        <label for="institution">สังกัด / หน่วยงาน <i class="text-red">* ตัวอย่าง:
                                                มหาวิทยาลัยราชภัฏเลย</i></label>
                                        <input @if (old('position_id') != '2') disabled @endif type="text"
                                            name="institution" id="institution"
                                            class="form-control @error('institution') is-invalid @enderror"
                                            value="{{ old('institution') }}" autocomplete="institution">

                                        @error('institution')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-12" id="select-kota">
                                <label>โควต้าเจ้าภาพร่วม
                                    @error('position_id')
                                        <span class="text-danger"> *กรุณาเลือกสถานะของท่าน</span>
                                    @enderror
                                </label>

                                @foreach ($kotas as $kota)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="kota_id"
                                            id="kota_{{ $kota->id }}" value="{{ $kota->id }}"
                                            @if (old('position_id') != '3') disabled @endif
                                            @if (!old('kota_id')) @if ($kota->id == $kotas->first()->id)
                                checked @endif
                                        @elseif (old('kota_id') == $kota->id) checked @endif>

                                        <label class="form-check-label" for="kota_{{ $kota->id }}">
                                            {{ $kota->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-12">
                                <label for="address">ที่อยู่ <span style="font-size: 12px;"
                                        class="text-bluesky">(ใช้ในการออกใบเสร็จรับเงิน และส่งเอกสาร)</span></label>
                                <textarea class="form-control @error('address') is-invalid @enderror" name="address" id="address" cols="30"
                                    rows="5">{{ old('address') }}</textarea>

                                @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-12">
                                <label>ความต้องการใบเสร็จรับเงิน</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="after_receive_check"
                                        name="receive_check" value="after" checked>

                                    <label for="after_receive_check" class="form-check-label">
                                        ต้องการใบเสร็จรับเงิน <span class="fw-bold">"หลัง"</span> วันจัดประชุม
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="before_receive_check"
                                        name="receive_check" value="before">

                                    <label for="before_receive_check" class="form-check-label">
                                        ต้องการใบเสร็จรับเงิน <span class="fw-bold">"ก่อน"</span> วันจัดประชุม
                                    </label>
                                </div>

                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-12">
                                <label>ท่านลงทะเบียนส่งผลงาน หรือเข้าร่วมงานทั่วไป ? @error('person_attend')
                                        <span class="text-danger"> * กรุณาเลือกวิธีลงทะเบียน</span>
                                    @enderror
                                </label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="person_attend" id="send"
                                        @if (old('person_attend') === 'send' || empty(old('person_attend'))) checked @endif value="send">
                                    <label class="form-check-label" for="send">
                                        ลงทะเบียนส่งผลงาน
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="person_attend" id="attend"
                                        @if (old('person_attend') === 'attend') checked @endif value="attend">
                                    <label class="form-check-label" for="attend">
                                        ลงทะเบียนเข้าร่วมงานทั่วไป
                                    </label>
                                </div>
                                <p style="color: red;">* บุคคลภายนอกจะต้องชำระค่าลงทะเบียน 2,000 บาท ต่อ 1 ผลงาน
                                </p>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-12">
                                <label for="email">อีเมล <span style="font-size: 12px;"
                                        class="text-bluesky">(จำเป็นต้องยืนยันตัวตนในอีเมล)</span></label>
                                <input type="text" name="email" id="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email') }}">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="password">รหัสผ่าน</label>
                                <input type="password" name="password" id="password"
                                    class="form-control @error('password') is-invalid @enderror">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="password_confirmation">ยืนยันรหัสผ่าน</label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="form-control @error('password_confirmation') is-invalid @enderror">
                            </div>
                        </div>
                        <div class="d-block">
                            <input onclick="thisDisabled(this)" name="register"
                                class="btn btn-green rounded-0 text-white text-white w-100" type="submit"
                                value="ลงทะเบียน">
                        </div>
                    </form>
                </div>
                <div class="col-md-5 tips">
                    <div class="tips-content">
                        @foreach ($tips as $tip)
                            <div class="tips-box py-5">
                                <div class="icon"><img src="{{ asset($tip->image, env('REDIRECT_HTTPS')) }}"
                                        alt="{{ $tip->head }}">
                                </div>
                                <div class="content"><strong>{{ $tip->head }}</strong><br /><span>
                                        <textarea readonly style="width: 100%;" class="txt-tips autosize">{{ $tip->detail }}</textarea>
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @else
            <h1 class="text-danger text-center">ยังไม่เปิดให้ลงทะเบียน</h1>
        @endif

    </div>
    <!-- End Content -->
@endsection
