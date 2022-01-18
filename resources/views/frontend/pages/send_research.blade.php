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
            <form action="#">
                <div class="mb-4">
                    <label for="research-th">ชื่อบทความ (ภาษาไทย)</label>
                    <input type="text" id="research-th" class="form-control">
                </div>
                <div class="mb-4">
                    <label for="research-en">ชื่อบทความ (ภาษาอังกฤษ)</label>
                    <input type="text" id="research-en" class="form-control">
                </div>
                <div class="mb-4">
                    <label for="research-person">ชื่อนักวิจัย (รวมถึงชื่อผู้ร่วมวิจัย)</label>
                    <div class="d-flex mb-4">
                        <label class="align-self-end" for="research-person1">1.&nbsp;</label>
                        <input type="text" id="research-person1" class="form-control">
                    </div>
                    <div class="d-flex mb-4">
                        <label class="align-self-end" for="research-person2">2.&nbsp;</label>
                        <input type="text" id="research-person2" class="form-control">
                    </div>
                    <div class="d-flex mb-4">
                        <label class="align-self-end" for="research-person3">3.&nbsp;</label>
                        <input type="text" id="research-person3" class="form-control">
                    </div>
                    <div class="d-flex mb-4">
                        <label class="align-self-end" for="research-person4">4.&nbsp;</label>
                        <input type="text" id="research-person4" class="form-control">
                    </div>
                    <div class="d-flex mb-4">
                        <label class="align-self-end" for="research-person5">5.&nbsp;</label>
                        <input type="text" id="research-person5" class="form-control">
                    </div>

                </div>
                <div class="mb-4">
                    <label for="research-group">บทความของท่านอยู่ในกลุ่ม</label>
                    <select name="research-group" id="research-group" class="form-select">
                        <option value="">---กรุณาเลือก---</option>
                        <option value="1">กลุ่มมนุษยศาสตร์/สังคมศาสตร์</option>
                        <option value="2">กลุ่มครุศาสตร์</option>
                        <option value="3">กลุ่มวิทยาศาสตร์และเทคโนโลยี</option>
                        <option value="4">กลุ่มบริหารธุรกิจ การบริการ และการท่องเที่ยว</option>
                        <option value="5">กลุ่มวิศวกรรม และอุตสาหกรรม</option>
                    </select>
                </div>
                <div class="mb-4" id="select-research-branch"></div>
                <div class="mb-4">
                    <label for="vol-research">ระดับบทความ</label>
                    <select class="form-select" name="vol-research" id="vol-research">
                        <option value="">---กรุณาเลือก---</option>
                        <option value="1">บทความวิจัย</option>
                        <option value="2">บทความวิชาการ</option>
                        <option value="3">บทความวิทยานิพนธ์</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="present-types">รูปแบบการนำเสนอ</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="present-type" id="oral" checked>
                        <label class="form-check-label" for="oral">
                            Oral (นำเสนอปากเปล่า)
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="present-type" id="poster">
                        <label class="form-check-label" for="poster">
                            Poster (การนำเสนอแบบโปสเตอร์)
                        </label>
                    </div>
                </div>
                <div class="mb-4">
                    <label for="register-types">ประเภทบุคลากรที่คุณลงทะเบียน</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="register-type" id="in-person" checked>
                        <label class="form-check-label" for="in-person">
                            บุคคลภายในมหาวิทยาลัยราชภัฏเลย
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="register-type" id="out-person">
                        <label class="form-check-label" for="out-person">
                            บุคคลภายนอก (มีค่าใช้จ่าย กรุณาชำระเงินก่อนส่งบทความ)
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="register-type" id="co-host">
                        <label class="form-check-label" for="co-host">
                            โควต้าเจ้าภาพร่วม
                        </label>
                    </div>
                    <span class="text-red">* หากสถานะไม่ถูกต้อง กรุณาแจ้งผู้ดูแลระบบ</span>
                </div>
                <div class="mb-4 border rounded p-4">
                    <label class="d-block" for="word-upload">อัพโหลดบทความ (ไฟล์ Word)</label>
                    <input class="w-100" accept=".doc, .docx, .dotx" type="file" name="word-upload" id="word-upload" />
                </div>

                <div class="mb-4 border rounded p-4">
                    <label class="d-block" for="pdf-upload">อัพโหลดบทความ (ไฟล์ PDF)</label>
                    <input class="w-100" accept=".pdf" type="file" name="pdf-upload" id="pdf-upload" />
                </div>

                <div class="mb-4">
                    <p class="mb-4">แนบหลักฐานการชำระเงิน <span class="text-warning">(เฉพาะ .png, .jpg, .gif)</span>
                    </p>
                    <div class="mb-4">
                        <label for="date-payment">วัน/เดือน/ปีที่ชำระเงิน</label><br />
                        <div class="mt-2 d-flex">
                            <input type="text" id="date-payment" readonly />
                            <i class="fas fa-calendar-alt date-payment-icon"
                                onclick="document.getElementById('date-payment').focus();"></i>
                        </div>
                    </div>

                    <br>
                    <img src="https://www.thaicontractor.com/wp-content/uploads/2019/11/pic-directory.png" id="output"
                        width="450px" class="img-fluid rounded pb-2"
                        onclick="document.getElementById('payment').click()">
                    <br>
                    <span class="btn btn-info rounded-0" onclick="document.getElementById('payment').click()">
                        <i class="fas fa-upload"></i> อัพโหลดหลักฐานการชำระเงิน <input class="d-none" type="file"
                            name="payment" id="payment" accept=".png, .jpg, .gif, .jpeg" required
                            onchange="document.getElementById('output').src = window.URL.createObjectURL(this.files[0])">
                    </span>
                </div>
                <div class="mb-4">
                    <label for="address-payment">ชื่อ - สกุล/ที่อยู่ในการออกใบเสร็จรับเงิน</label>
                    <textarea name="address-payment" id="address-payment" cols="30" rows="5"
                        class="form-control"></textarea>

                </div>

                <div class="row border borber-primary p-3 mt-3 mb-3">
                    <div class="form-group mt-2 mb-2 col-md-12">
                        <label for="checkbox">
                            <h5>โปรดยืนยันข้อตกลง</h5>
                        </label>
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="exampleCheck1" required>
                            <label class="form-check-label"
                                for="exampleCheck1">ข้าพเจ้าขอยืนยันว่าผลงานบทความดังกล่าวไม่เคยนำไปเสนอในที่ประชุมวิชาการหรือตีพิมพ์เผยแพร่ในวารสารใดๆ
                                มาก่อน</label>
                        </div>
                    </div>
                </div>
                <p class="text-red text-center">
                    * กรุณาตรวจสอบความถูกต้องก่อนกดส่งบทความของท่าน
                </p>
                <input class="btn btn-green text-white w-100 rounded-0" type="button" name="send-research"
                    value="ส่งบทความ" />
            </form>
        </div>
        <div class="col-md-5 tips">
            <div class="tips-content">
                <div class="tips-box py-5">
                    <div class="icon"><img src="./image/guide.png" alt=""></div>
                    <div class="content"><strong>แนะนำการลงทะเบียน</strong><br /><span>
                            กรณีต้องการลงทะเบียนเข้าร่วมงานแต่ไม่ส่งบทความ หรือเป็นนักวิจัยร่วม ให้เลือก
                            "ลงทะเบียนเข้าร่วมงานทั่วไป" หากสงสัยให้ติดต่อเจ้าหน้ที่หรือผู้ดูแลระบบ</span></div>
                </div>
                <div class="tips-box py-5">
                    <div class="icon"><img src="./image/folder.png" alt=""></div>
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
                    <div class="icon"><img src="./image/heart.png" alt=""></div>
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
                    <div class="icon"><img src="./image/money-exchange.png" alt=""></div>
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