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
            <h4 class="text-center">ส่งบทความ</h4>
            <h4 class="text-green py-3">
                LRU Conference 2022
            </h4>
        </div>
        <div class="row w-100">
            <div class="col-md-7">
                <form action="{{ route('employee.research.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="nameTh">ชื่อบทความ (ภาษาไทย)</label>
                        <input type="text" id="nameTh" name="nameTh" value="{{ old('nameTh') }}"
                            class="form-control @error('nameTh')
                        is-invalid                        
                    @enderror"
                            autocomplete="nameTh" autofocus>

                        @error('nameTh')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="nameEn">ชื่อบทความ (ภาษาอังกฤษ)</label>
                        <input type="text" id="nameEn" name="nameEn" value="{{ old('nameEn') }}"
                            class="form-control @error('nameEn')
                        is-invalid
                    @enderror"
                            autocomplete="nameEn">

                        @error('nameEn')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label>ชื่อนักวิจัย (รวมถึงชื่อผู้ร่วมวิจัย)</label>
                        <div class="d-flex mb-4">
                            <label class="align-self-end" for="nameResearch1">1.&nbsp;</label>
                            <input type="text" id="nameResearch1" name="nameResearch1"
                                class="form-control @error('nameResearch1')
                            is-invalid
                        @enderror"
                                value="{{ old('nameResearch1') }}" autocomplete="nameResearch1">

                            @error('nameResearch1')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="d-flex mb-4">
                            <label class="align-self-end" for="nameResearch2">2.&nbsp;</label>
                            <input type="text" id="nameResearch2" name="nameResearch2" class="form-control"
                                value="{{ old('nameResearch2') }}" autocomplete="nameResearch2">
                        </div>
                        <div class="d-flex mb-4">
                            <label class="align-self-end" for="nameResearch3">3.&nbsp;</label>
                            <input type="text" id="nameResearch3" name="nameResearch3" class="form-control"
                                value="{{ old('nameResearch3') }}" autocomplete="nameResearch3">
                        </div>
                        <div class="d-flex mb-4">
                            <label class="align-self-end" for="nameResearch4">4.&nbsp;</label>
                            <input type="text" id="nameResearch4" name="nameResearch4" class="form-control"
                                value="{{ old('nameResearch4') }}" autocomplete="nameResearch4">
                        </div>
                        <div class="d-flex mb-4">
                            <label class="align-self-end" for="nameResearch5">5.&nbsp;</label>
                            <input type="text" id="nameResearch5" name="nameResearch5" class="form-control"
                                value="{{ old('nameResearch5') }}" autocomplete="nameResearch5">
                        </div>

                    </div>
                    <div class="mb-4">
                        <label for="group">บทความของท่านอยู่ในกลุ่ม</label>
                        <select name="group" id="group"
                            class="form-select @error('group')
                        is-invalid
                    @enderror"
                            onchange="selectGroup(this)">
                            <option value="" @if (empty('group'))
                                selected
                                @endif>---กรุณาเลือก---</option>
                            <option value="กลุ่มมนุษยศาสตร์/สังคมศาสตร์" @if (old('group') === 'กลุ่มมนุษยศาสตร์/สังคมศาสตร์')
                                selected
                                @endif>กลุ่มมนุษยศาสตร์/สังคมศาสตร์</option>
                            <option value="กลุ่มครุศาสตร์/ศึกษาศาสตร์" @if (old('group') === 'กลุ่มครุศาสตร์/ศึกษาศาสตร์')
                                selected
                                @endif>กลุ่มครุศาสตร์/ศึกษาศาสตร์</option>
                            <option value="กลุ่มวิทยาศาสตร์และเทคโนโลยี" @if (old('group') === 'กลุ่มวิทยาศาสตร์และเทคโนโลยี')
                                selected
                                @endif>กลุ่มวิทยาศาสตร์และเทคโนโลยี</option>
                            <option value="กลุ่มบริหารธุรกิจ การบริการ และการท่องเที่ยว" @if (old('group') === 'กลุ่มบริหารธุรกิจ การบริการ และการท่องเที่ยว')
                                selected
                                @endif>กลุ่มบริหารธุรกิจ การบริการ
                                และการท่องเที่ยว</option>
                            <option value="กลุ่มวิศวกรรม และอุตสาหกรรม" @if (old('group') === 'กลุ่มวิศวกรรม และอุตสาหกรรม')
                                selected
                                @endif>กลุ่มวิศวกรรม และอุตสาหกรรม</option>
                        </select>

                        @error('group')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="group2">สาขาย่อย</label>
                        <select name="group2" id="group2"
                            class="form-select @error('group2')
                        is-invalid
                    @enderror"
                            disabled>
                            <option value="">---กรุณาเลือก---</option>
                        </select>

                        @error('group2')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>


                    <div class="mb-4" id="select-research-branch"></div>
                    <div class="mb-4">
                        <label for="volResearch">ระดับบทความ</label>
                        <select class="form-select" name="volResearch" id="volResearch">
                            <option value="">---กรุณาเลือก---</option>
                            <option value="บทความวิจัย">บทความวิจัย</option>
                            <option value="บทความวิชาการ">บทความวิชาการ</option>
                            <option value="บทความวิทยานิพนธ์">บทความวิทยานิพนธ์</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="presentTypes">รูปแบบการนำเสนอ</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="presentTypes" id="oral" value="oral" checked>
                            <label class="form-check-label" for="oral">
                                Oral (นำเสนอปากเปล่า)
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="presentTypes" id="poster" value="poster">
                            <label class="form-check-label" for="poster">
                                Poster (การนำเสนอแบบโปสเตอร์)
                            </label>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label>ประเภทบุคลากรที่คุณลงทะเบียน</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="personTypes" id="in" value="in" checked>
                            <label class="form-check-label" for="in">
                                บุคคลภายในมหาวิทยาลัยราชภัฏเลย
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="personTypes" id="out" value="out">
                            <label class="form-check-label" for="out">
                                บุคคลภายนอก (มีค่าใช้จ่าย กรุณาชำระเงินก่อนส่งบทความ)
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="personTypes" id="kota" value="kota">
                            <label class="form-check-label" for="kota">
                                โควต้าเจ้าภาพร่วม
                            </label>
                        </div>
                        <span class="text-red">* หากสถานะไม่ถูกต้อง กรุณาแจ้งผู้ดูแลระบบ</span>
                    </div>

                    <p class="text-red text-center">
                        * กรุณาตรวจสอบความถูกต้องก่อนกดส่งบทความของท่าน
                    </p>
                    <button class="btn btn-green text-white w-100 rounded-0" type="submit">ส่งบทความ</button>
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
