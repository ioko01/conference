@extends('frontend.layouts.master_frontend')

@section('content')
    <!-- Breadcrumb -->
    <div class="py-5">
        <div class="row text-end m-0">
            <div class="col-5 col-md-4 col-lg-3 col-xl-2 bg-white breadcrumb">
                <p><strong>ลงทะเบียน > ส่งบทความ</strong></p>
            </div>
        </div>
    </div>
    <!-- End Breadcrumb -->

    <!-- Content -->
    <div id="register-content" class="bg-white text-blue p-5 mb-5">
        <div class="inner-content-header">
            <h2 class="text-center">ส่งบทความ</h2>
            <h4 class="text-green py-3">
                LRU Conference 2022
            </h4>
        </div>
        <div class="row w-100">
            <div class="col-md-7">
                <form action="{{ route('employee.research.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="topic_th">ชื่อบทความ (ภาษาไทย)</label>
                        <input type="text" id="topic_th" name="topic_th" value="{{ old('topic_th') }}"
                            class="form-control @error('topic_th')
                        is-invalid                        
                    @enderror"
                            autocomplete="topic_th" autofocus>

                        @error('topic_th')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="topic_en">ชื่อบทความ (ภาษาอังกฤษ)</label>
                        <input type="text" id="topic_en" name="topic_en" value="{{ old('topic_en') }}"
                            class="form-control @error('topic_en')
                        is-invalid
                    @enderror"
                            autocomplete="topic_en">

                        @error('topic_en')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label>ชื่อนักวิจัย (รวมถึงชื่อผู้ร่วมวิจัย)</label>
                        <div class="mb-4">
                            <span>1.&nbsp;</span>
                            <input type="text" id="presenters[]" name="presenters[]"
                                class="form-control w-100 @error('presenters.0')
                            is-invalid
                        @enderror"
                                value="{{ old('presenters.0') }}" autocomplete="presenters[0]">

                            @error('presenters.0')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <span>2.&nbsp;</span>
                            <input type="text" id="presenters[]" name="presenters[]" class="form-control w-100"
                                value="{{ old('presenters.1') }}" autocomplete="presenters[1]">
                        </div>
                        <div class="mb-4">
                            <span>3.&nbsp;</span>
                            <input type="text" id="presenters[]" name="presenters[]" class="form-control w-100"
                                value="{{ old('presenters.2') }}" autocomplete="presenters[2]">
                        </div>
                        <div class="mb-4">
                            <span>4.&nbsp;</span>
                            <input type="text" id="presenters[]" name="presenters[]" class="form-control w-100"
                                value="{{ old('presenters.3') }}" autocomplete="presenters[3]">
                        </div>
                        <div class="mb-4">
                            <span>5.&nbsp;</span>
                            <input type="text" id="presenters[]" name="presenters[]" class="form-control w-100"
                                value="{{ old('presenters.4') }}" autocomplete="presenters[4]">
                        </div>

                    </div>
                    <div class="mb-4">
                        <label for="faculty_id">บทความของท่านอยู่ในกลุ่ม</label>
                        <select name="faculty_id" id="faculty_id"
                            class="form-select @error('faculty_id')
                        is-invalid
                    @enderror"
                            onchange="select_faculty(this)">
                            <option value="" @if (!old('faculty_id')) selected @endif>---กรุณาเลือก---</option>
                            @foreach ($faculties as $faculty)
                                <option value="{{ $faculty->id }}" @if ($faculty->id == old('faculty_id'))
                                    selected
                            @endif>
                            {{ $faculty->name }}
                            </option>
                            @endforeach
                        </select>

                        @error('faculty_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="branch_id">สาขาย่อย</label>
                        <select name="branch_id" id="branch_id"
                            class="form-select @error('branch_id')
                        is-invalid
                    @enderror"
                            @if (!old('faculty_id'))
                            disabled
                            @endif>
                            <option value="" @if (!old('branch_id')) selected @endif>---กรุณาเลือก---</option>
                            @foreach ($branches as $branch)
                                @if ($branch->faculty_id == old('faculty_id'))
                                    <option value="{{ $branch->id }}" @if ($branch->id == old('branch_id'))
                                        selected
                                @endif>
                                {{ $branch->name }}
                                </option>
                            @endif
                            @endforeach
                        </select>

                        @error('branch_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>


                    <div class="mb-4" id="select-research-branch"></div>
                    <div class="mb-4">
                        <label for="degree_id">ระดับบทความ</label>
                        <select class="form-select" name="degree_id" id="degree_id">
                            <option value="" @if (empty(old('degree_id'))) selected @endif>---กรุณาเลือก---</option>
                            @foreach ($degrees as $degree)
                                <option value="{{ $degree->id }}" @if ($degree->id == old('degree_id')) selected @endif>
                                    {{ $degree->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="present_id">รูปแบบการนำเสนอ</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="present_id" id="0" value="0"
                                @if (empty(old('present_id')) || old('present_id') === '0') checked @endif>
                            <label class="form-check-label" for="0">
                                Oral (นำเสนอปากเปล่า)
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="present_id" id="1" value="1"
                                @if (old('present_id') === '1') checked @endif>
                            <label class="form-check-label" for="1">
                                Poster (การนำเสนอแบบโปสเตอร์)
                            </label>
                        </div>
                    </div>

                    <p class="text-red text-center">
                        * กรุณาตรวจสอบความถูกต้องก่อนกดส่งบทความของท่าน
                    </p>
                    <button class="btn btn-green text-white w-100 rounded-0" name="send_research" type="submit">ส่งบทความ</button>
                </form>
            </div>
            <div class="col-md-5 tips">
                <div class="tips-content">
                    <div class="tips-box py-5">
                        <div class="icon"><img src="{{ asset('images/guide.png') }}" alt=""></div>
                        <div class="content"><strong>แนะนำการลงทะเบียน</strong><br /><span>
                                กรณีต้องการลงทะเบียนเข้าร่วมงานแต่ไม่ส่งบทความ หรือเป็นนักวิจัยร่วม ให้เลือก
                                "ลงทะเบียนเข้าร่วมงานทั่วไป" หากสงสัยให้ติดต่อเจ้าหน้ที่หรือผู้ดูแลระบบ</span></div>
                    </div>
                    <div class="tips-box py-5">
                        <div class="icon"><img src="{{ asset('images/folder.png') }}" alt=""></div>
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
                        <div class="icon"><img src="{{ asset('images/heart.png') }}" alt=""></div>
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
