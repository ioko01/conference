@extends('frontend.layouts.master_frontend')

@section('content')
    <!-- Breadcrumb -->
    <div class="py-5">
        <div class="row text-end m-0">
            <div class="col-5 col-md-4 col-lg-3 col-xl-2 bg-white breadcrumb">
                <p><strong>ลงทะเบียน > สมัครเข้าใช้ระบบ</strong></p>

            </div>
        </div>
    </div>
    <!-- End Breadcrumb -->

    <!-- Content -->
    <div id="register-content" class="bg-white text-blue p-5 mb-5">
        <div class="inner-content-header">
            <h4 class="text-center">ลงทะเบียนส่งผลงาน / เข้าร่วมงาน</h4>
            <h4 class="text-green py-3">
                LRU Conference 2022
            </h4>
        </div>
        <div class="row w-100">
            <div class="col-md-7">
                <form action="{{ route('register') }}" method="POST">
                    @csrf
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="prefix">คำนำหน้า <span style="font-size: 12px;"
                                    class="text-bluesky">(ใช้ลงในเกียรติบัตร)</span></label>
                            <input type="text" name="prefix" id="prefix"
                                class="form-control @error('prefix')
                            is-invalid
                        @enderror"
                                value="{{ old('prefix') }}" autocomplete="prefix" autofocus>

                            @error('prefix')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="fullname">ชื่อ - สกุล</label>
                            <input type="text" name="fullname" id="fullname"
                                class="form-control @error('fullname')
                            is-invalid
                        @enderror"
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
                                <input class="form-check-input" type="radio" name="sex" id="male" @if (old('sex') === 'male' || empty(old('sex'))) checked @endif
                                    value="male">
                                <label class="form-check-label" for="male">
                                    ชาย
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="sex" id="female" @if (old('sex') === 'female') checked @endif
                                    value="female">
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
                            <label for="phone">เบอร์โทร</label>
                            <input type="text" name="phone" id="phone"
                                class="form-control @error('phone')
                            is-invalid
                        @enderror"
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
                            <label for="institution">สังกัด / หน่วยงาน</label>
                            <input type="text" name="institution" id="institution"
                                class="form-control @error('institution')
                            is-invalid
                        @enderror"
                                value="{{ old('institution') }}" autocomplete="institution">

                            @error('institution')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-12">
                            <label for="address">ที่อยู่ <span style="font-size: 12px;"
                                    class="text-bluesky">(ใช้ในการส่งเอกสาร)</span></label>
                            <textarea
                                class="form-control @error('address')
                            is-invalid
                        @enderror"
                                name="address" id="address" cols="30" rows="5">{{ old('address') }}</textarea>

                            @error('address')
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
                                        onchange="toggle_kota(this)" @if (!old('position_id'))
                                    @if ($position->id == $positions->first()->id)
                                        checked
                                    @endif
                                @elseif(old('position_id') == $position->id)
                                    checked
                            @endif>

                            <label class="form-check-label" for="position_{{ $position->id }}">
                                {{ $position->name }}
                            </label>
                        </div>
                        @endforeach

                        <p style="color:red">* โควต้าเจ้าภาพร่วมกรุณาติดต่อต้นสังกัด
                            หากท่านเป็นบุคลากรภายในมหาวิทยาลัยราชภัฏเลย และบทความของท่านเป็นของมหาวิทยาลัยอื่น
                            จะต้องลงทะเบียนเป็น "บุคคลภายนอก"
                        </p>
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
                            <input class="form-check-input" type="radio" name="kota_id" id="kota_{{ $kota->id }}"
                                value="{{ $kota->id }}" @if (old('position_id') != "3") disabled @endif @if (!old('kota_id'))
                            @if ($kota->id == $kotas->first()->id)
                                checked
                            @endif
                        @elseif (old('kota_id') == $kota->id)
                            checked
                    @endif>

                    <label class="form-check-label" for="kota_{{ $kota->id }}">
                        {{ $kota->name }}
                    </label>
                </div>
                @endforeach

            </div>
        </div>
        <div class="row mb-4">
            <div class="col-12">
                <label>ท่านลงทะเบียนส่งผลงาน หรือเข้าร่วมงานทั่วไป ? @error('person_attend')
                        <span class="text-danger"> * กรุณาเลือกวิธีลงทะเบียน</span>
                    @enderror
                </label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="person_attend" id="send" @if (old('person_attend') === 'send' || empty(old('person_attend'))) checked @endif
                        value="send">
                    <label class="form-check-label" for="send">
                        ลงทะเบียนส่งผลงาน
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="person_attend" id="attend" @if (old('person_attend') === 'attend') checked @endif
                        value="attend">
                    <label class="form-check-label" for="attend">
                        ลงทะเบียนเข้าร่วมงานทั่วไป
                    </label>
                </div>
                <p style="color: red;">* บุคคลภายนอกจะต้องชำระค่าลงทะเบียน 2,000 บาท ต่อ 1 ผลงาน /
                    ลงทะเบียนเข้าร่วมงานทั่วไป 1,000 ต่อ 1 ท่าน * กรณีที่ท่านเป็นผู้ร่วมวิจัยฯ
                    ให้หัวหน้าโครงการลงทะเบียนส่งผลงาน และท่านลงทะเบียนเข้าร่วมงานทั่วไป
                </p>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-12">
                <label for="email">อีเมล <span style="font-size: 12px;"
                        class="text-bluesky">(จำเป็นต้องยืนยันตัวตนในอีเมล)</span></label>
                <input type="text" name="email" id="email"
                    class="form-control @error('email')
                            is-invalid
                        @enderror"
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
                    class="form-control @error('password')
                            is-invalid
                        @enderror">

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="password_confirmation">ยืนยันรหัสผ่าน</label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                    class="form-control @error('password_confirmation')
                            is-invalid
                        @enderror">
            </div>
        </div>
        <div class="d-block">
            <input class="btn btn-green rounded-0 text-white text-white w-100" type="submit" value="ลงทะเบียน">
        </div>
        </form>
    </div>
    <div class="col-md-5 tips">
        <div class="tips-content">
            <div class="tips-box py-5">
                <div class="icon"><img src="{{ asset('images/guide.png') }}" alt="guide-register">
                </div>
                <div class="content"><strong>แนะนำการลงทะเบียน</strong><br /><span>
                        กรณีต้องการลงทะเบียนเข้าร่วมงานแต่ไม่ส่งบทความ หรือเป็นนักวิจัยร่วม ให้เลือก
                        "ลงทะเบียนเข้าร่วมงานทั่วไป" หากสงสัยให้ติดต่อเจ้าหน้ที่หรือผู้ดูแลระบบ</span></div>
            </div>
            <div class="tips-box py-5">
                <div class="icon"><img src="{{ asset('images/folder.png') }}" alt="guide-send"></div>
                <div class="content"><strong>แนะนำการส่งผลงาน</strong><br /><span>
                        เมื่อลงทะเบียนสำเร็จแล้ว ระบบจะส่งลิงก์
                        ไปยังอีเมลของท่านเพื่อยืนยันตัวตน
                        จึงจะสามารถใช้ระบบส่งผลงานได้
                        (ผู้ที่ส่งผลงานจะต้องเลือก
                        "ลงทะเบียนส่งผลงาน" เท่านั้น !)
                        และจะต้องใส่ข้อมูลที่ถูกต้อง
                        หากเกิดข้อผิดพลาดผู้ลงทะเบียน
                        ใส่ข้อมูลมาผิด เจ้าหน้าที่จะไม่รับผิดชอบ</span></div>
            </div>
            <div class="tips-box py-5">
                <div class="icon"><img src="{{ asset('images/heart.png') }}" alt="guide"></div>
                <div class="content"><strong>การพิจารณาผลงาน</strong><br /><span>
                        พิจารณาการเลือกกลุ่มการนำเสนอ
                        ผลงานและประเภทของการนำเสนอ
                        ผลงาน โดยผู้ทรงคุณวุฒิจากภายใน
                        และภายนอกมหาวิทยาลัย อย่างน้อย 2 ท่าน
                        และคัดเลือกผลงานที่นำเสนอในการประชุม
                        รวบรวมเป็นรายงานสืบเนื่องจากการประชุม
                        วิชาการระดับชาติ Proceedings
                        (ทั้งนี้บทความต้องได้รับการชำระเงินเท่านั้น..!
                        ที่จะได้รับสิทธิ์ให้ผู้ทรงคุณวิฒิพิจารณา)</span></div>
            </div>
            <div class="tips-box py-5">
                <div class="icon"><img src="{{ asset('images/money-exchange.png') }}" alt=""></div>
                <div class="content"><strong>การชำระเงิน</strong><br /><span>
                        1. ผู้นำเสนอจากหน่วยงานภายนอก ที่ส่งผลงาน ค่าลงทะเบียนอัตรา 2,000 บาท ต่อ 1 ผลงาน <br />
                        2. ผู้ร่วมงานทั่วไป/นิสิต/นักศึกษาจากหน่วยงานภายนอก ไม่เสียค่าใช้จ่าย <br />
                        3. บุคลากรภายในมหาวิทยาลัยราชภัฏเลย ไม่เสียค่าใช้จ่าย <br />
                        4.
                        ข้าราชการหรือบุคลากรของรัฐที่เข้าร่วมประชุมสามารถเบิกจ่ายได้จากต้นสังกัดตามระเบียบของกระทรวงการคลัง
                        <br />
                        หมายเหตุ: กรณีที่ผู้สมัครเข้าร่วมงานและไม่สามารถมานำเสนอผลงานได้ สถาบันวิจัยและพัฒนา
                        ขอสงวนสิทธิ์ ที่จะไม่คืนเงินค่าลงทะเบียนไม่ว่ากรณีใดๆ
                        เนื่องจากต้องมีค่าใช้จ่ายในระหว่างการดำเนินงาน</span></div>
            </div>
        </div>
    </div>
    </div>
    </div>
    <!-- End Content -->
@endsection
