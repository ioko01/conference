@extends('frontend.layouts.master_frontend')

@section('content')
    <!-- Content -->
    <div id="register-content" class="bg-white text-blue p-5 my-5">
        @if (isset($conference_id->id))
            @if ($conference_id->status_research == 0)
                <h1 class="text-danger text-center">
                    <i class="fas fa-2x fa-times"></i><br />
                    <strong style="font-size: calc(.5vw + 10px);">
                        ยังไม่เปิดให้ลงทะเบียน
                    </strong>
                </h1>
            @else
                @if (endDate('end_research')->day < 0 && endDate('end_attend')->day < 0)
                    <h1 class="text-danger text-center">
                        <i class="fas fa-2x fa-clock"></i><br />
                        <strong style="font-size: calc(.5vw + 10px);">
                            หมดเวลาการลงทะเบียนแล้ว
                        </strong>
                    </h1>
                @else
                    <div class="inner-content-header">
                        <h4 class="text-center">ลงทะเบียน</h4>
                        <h4 class="text-green py-3">
                            {{ config('app.name') }}
                        </h4>
                    </div>
                    <div class="row w-100">
                        <div class="col-md-7">
                            <form id="form_register"
                                @if (old('person_attend') == 'send') action="{{ route('register') }}" @elseif(old('person_attend') == 'attend') action="{{ route('attend.store') }}" @elseif(endDate('end_research')->day >= 0) action="{{ route('register') }}" @else action="{{ route('attend.store') }}" @endif
                                method="POST">
                                @csrf
                                <div class="row mb-4">
                                    <div class="col-md-4">
                                        <label for="prefix">คำนำหน้า</label>
                                        <select id="prefix" name="prefix"
                                            class="form-select @error('prefix') is-invalid @enderror" autocomplete="prefix"
                                            autofocus>
                                            @forelse ($prefixs as $prefix)
                                                <option
                                                    @if ($loop->first && !old('prefix')) selected @elseif (old('prefix') == $prefix) selected @endif
                                                    value="{{ $prefix }}">{{ $prefix }}
                                                </option>
                                            @empty
                                            @endforelse
                                        </select>
                                        @error('prefix')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-8">
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
                                        <label for="phone">เบอร์โทร <i class="text-red text-small">* ใส่ตัวเลข 10
                                                หลักโดยไม่ต้องใส่
                                                "-"</i></label>
                                        <input type="tel" name="phone" id="phone"
                                            class="form-control @error('phone') is-invalid @enderror"
                                            value="{{ old('phone') }} " autocomplete="phone">

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

                                        <p style="color:red" class="text-small">
                                            *
                                            ลงทะเบียนผู้ทรงคุณวุฒิต้องรอการตรวจสอบจากระบบ
                                            <br />
                                            * โควต้าเจ้าภาพร่วมกรุณาติดต่อต้นสังกัด
                                            หากท่านเป็นบุคลากรภายในมหาวิทยาลัยราชภัฏเลย
                                            และบทความของท่านเป็นของมหาวิทยาลัยอื่น
                                            จะต้องลงทะเบียนเป็น "บุคคลภายนอก"
                                        </p>

                                        <div class="row mb-4">
                                            <div class="col-12">
                                                <label for="institution">สังกัด / หน่วยงาน <i class="text-red text-small">*
                                                        ตัวอย่าง:
                                                        มหาวิทยาลัยราชภัฏเลย</i></label>
                                                <input @if (old('position_id') != '2' && old('position_id') != '4') disabled @endif type="text"
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
                                @if (count($kotas) > 0)
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
                                @endif


                                <div class="row mb-4">
                                    <div class="col-12" id="select-attend">
                                        <label>ท่านลงทะเบียนส่งผลงาน หรือเข้าร่วมงานทั่วไป ? @error('person_attend')
                                                <span class="text-danger"> * กรุณาเลือกวิธีลงทะเบียน</span>
                                            @enderror
                                        </label>
                                        @if (endDate('end_research')->day >= 0)
                                            <div class="form-check">
                                                <input onchange="toggle_attend(this, '{{ route('register') }}')"
                                                    class="form-check-input" type="radio" name="person_attend"
                                                    id="send" @if (old('person_attend') === 'send' || empty(old('person_attend'))) checked @endif
                                                    value="send">
                                                <label class="form-check-label" for="send">
                                                    ลงทะเบียนส่งผลงาน <span
                                                        class="text-red text-small">(บุคคลภายนอกจะต้องชำระค่าลงทะเบียน
                                                        2,000
                                                        บาท
                                                        ต่อ 1 ผลงาน)</span>
                                                </label>
                                            </div>
                                        @endif
                                        @if (endDate('end_attend')->day >= 0)
                                            <div class="form-check">
                                                <input onchange="toggle_attend(this, '{{ route('attend.store') }}')"
                                                    class="form-check-input" type="radio" name="person_attend"
                                                    id="attend" @if (endDate('end_research')->day < 0 || old('person_attend') === 'attend') checked @endif
                                                    value="attend">
                                                <label class="form-check-label" for="attend">
                                                    ลงทะเบียนเข้าร่วมงานทั่วไป
                                                </label>
                                                <br />
                                                @if (endDate('end_research')->day < 0)
                                                    <span class="text-red text-small">*
                                                        หมดเวลาการลงทะเบียนส่งผลงานแล้ว
                                                        สามารถลงทะเบียนเข้าร่วมงานได้เท่านั้น</span>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-12 d-none @if (old('person_attend') == 'attend' || old('position_id') == '1' || old('position_id') == '3') d-none @endif"
                                        id="form_address">
                                        <label for="address">ชื่อ - สกุล ที่อยู่ <span style="font-size: 12px;"
                                                class="text-bluesky">(ใช้ในการออกใบเสร็จรับเงิน
                                                และส่งเอกสาร)</span></label>
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
                                    <div class="col-12 d-none @if (old('person_attend') == 'attend' || old('position_id') == '1' || old('position_id') == '3') d-none @endif"
                                        id="form_receive">
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
                                        <label for="email">อีเมล <span class="text-red text-small">*
                                                หากลงทะเบียนส่งผลงานจำเป็นต้องยืนยันตัวตนในอีเมล</span></label>
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



                                <div id="form_password"
                                    class="row mb-4 @if (old('person_attend') == 'attend') d-none @endif">
                                    @if (endDate('end_research')->day >= 0)
                                        <div class="col-md-6">
                                            <div class="d-flex justify-content-between">
                                                <label for="password">รหัสผ่าน</label>
                                                <div class="toggle-password">

                                                </div>
                                            </div>
                                            <input type="password" name="password" id="password"
                                                class="form-control eye-icon @error('password') is-invalid @enderror">

                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror

                                        </div>
                                        <div class="col-md-6">
                                            <label for="password_confirmation">ยืนยันรหัสผ่าน</label>
                                            <input type="password" name="password_confirmation"
                                                id="password_confirmation"
                                                class="form-control @error('password_confirmation') is-invalid @enderror">
                                        </div>
                                    @endif
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
                                        <div class="content"><strong
                                                style="font-size: 18px">{{ $tip->head }}</strong><br /><span>
                                                <textarea readonly style="width: 100%;font-size: 14px;" class="txt-tips autosize">{{ $tip->detail }}</textarea>
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            @endif
        @else
            <h1 class="text-danger text-center">
                <i class="fas fa-2x fa-times"></i><br />
                <strong style="font-size: calc(.5vw + 10px);">
                    ยังไม่เปิดให้ลงทะเบียน
                </strong>
            </h1>
        @endif

    </div>
    <!-- End Content -->
@endsection
