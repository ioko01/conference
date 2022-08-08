@extends('frontend.layouts.master_frontend')

@section('content')

<!-- Content -->
<div id="payment-content" class="bg-white text-blue p-5 my-5">
    <div class="inner-content-header">
        <h4 class="text-center">รายละเอียดและวิธีการชำระเงินค่าลงทะเบียน</h4>
        <h4 class="text-green py-3">
            {{ config('app.name') }}
        </h4>
    </div>
    <div class="row">
        <div class="col-md-7">
            <h2>รูปแบบการชำระเงิน</h2>
            <p class="text-green">
                <strong>ชำระค่าลงทะเบียนผ่านธนาคาร เข้าบัญชีออมทรัพย์ชื่อบัญชี
                    <span class="text-bluesky">“วารสารวิจัยและพัฒนา ม.ราชภัฏเลย”เลขที่บัญชี 981-2-85863-6 ธนาคารกรุงไทย
                        สาขาเลย</span>
                </strong>
            </p>

            <p class="text-dark">
                <strong>
                    1. ผู้นำเสนอจากหน่วยงานภายนอก
                </strong> ที่ส่งผลงาน ค่าลงทะเบียนอัตรา 2,000 บาท ต่อ 1 ผลงาน<br />
                <strong>
                    2. ผู้ร่วมงานทั่วไป/นิสิต/นักศึกษาจากหน่วยงานภายนอก
                </strong> ไม่เสียค่าใช้จ่าย
                <br />
                <strong>
                    3. บุคลากรภายในมหาวิทยาลัยราชภัฏเลย
                </strong> ไม่เสียค่าใช้จ่าย
                <br /> 4.
                ข้าราชการหรือบุคลากรของรัฐที่เข้าร่วมประชุมสามารถเบิกจ่ายได้จากต้นสังกัดตามระเบียบของกระทรวงการคลัง
            </p>

            <p class="text-red">
                <strong>
                    * หมายเหตุ: กรณีที่ผู้สมัครเข้าร่วมงานและไม่สามารถมานำเสนอผลงานได้ สถาบันวิจัยและพัฒนา ขอสงวนสิทธิ์
                    ที่จะไม่คืนเงินค่าลงทะเบียนไม่ว่ากรณีใดๆ เนื่องจากต้องมีค่าใช้จ่ายในระหว่างการดำเนินงาน
                </strong>
            </p>

            <h2>วิธีการชำระเงิน</h2>
            <p>
                1. ชำระค่าลงทะเบียนผ่านธนาคาร เข้าบัญชีออมทรัพย์ชื่อบัญชี “วารสารวิจัยและพัฒนา ม.ราชภัฏเลย”เลขที่บัญชี
                981-2-85863-6 ธนาคารกรุงไทย สาขาเลย
                <br />2. แนบหลักฐานการชำระเงินผ่านทางเว็บไซต์
            </p>
        </div>
        <div class="col-5 tips">
            <div class="tips-content">
                @foreach ($tips as $tip)    
                    <div class="tips-box py-5">
                        <div class="icon"><img src="{{ asset($tip->image, env('REDIRECT_HTTPS')) }}" alt="{{ $tip->head }}"></div>
                        <div class="content"><strong>{{ $tip->head }}</strong><br /><span><textarea readonly style="width: 100%;" class="txt-tips autosize">{{ $tip->detail }}</textarea></span></div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<!-- End Content -->
@endsection