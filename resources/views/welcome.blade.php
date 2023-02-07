@extends('frontend.layouts.master_frontend')

@section('content')
    <!-- Poster -->
    <header id="poster1">
        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
                    aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                    aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                    aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img style="cursor: pointer"
                        title="https://drive.google.com/file/d/1RTJERejDQBTjeGRdxfasEpbDRwGF3uDQ/view?usp=share_link" onclick="window.open('https\:\/\/drive.google.com/file/d/1RTJERejDQBTjeGRdxfasEpbDRwGF3uDQ/view?usp=share_link')"
                        src="{{ asset('images/banner-03.jpg', env('REDIRECT_HTTPS')) }}" class="d-block w-100"
                        alt="banner3">
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('images/banner-02.jpg', env('REDIRECT_HTTPS')) }}" class="d-block w-100"
                        alt="banner2">
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('images/banner-01.webp', env('REDIRECT_HTTPS')) }}" class="d-block w-100"
                        alt="banner1">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </header>

    <div class="d-flex align-items-center p-md-5 py-5 bg-white justify-content-center text-green w-100" id="countdown">
    </div>

    <div style="overflow: hidden;" class="row bg-white m-0">
        <div class="row">
            @forelse ($downloads as $key =>$download)
                @if ($download->ext_file == 'jpg' || $download->ext_file == 'png' || $download->ext_file == 'jpeg')
                    <div class="animate fade-up col-md-3 mx-auto">
                        <h3 class="text-center text-blue fw-bold">{{ $download->name }}</h3>
                        <div class="card-body position-relative p-0">
                            <div style="z-index: 9999;" class="position-absolute end-0">
                                @if (countDate($download->created_at, 10, 'days'))
                                    <div class="box-new">
                                        <span style="font-size: calc(15px + .3vw);">ใหม่</span>
                                    </div>
                                @endif
                            </div>
                            <img width="100%" src="{{ Storage::url($download->path_file) }}" alt="#">
                        </div>
                    </div>
                @endif
            @empty
            @endforelse
        </div>



        @forelse ($downloads as $key =>$download)
            @if ($loop->first)
                <div class="animate fade-right col-md-6">
                    <div id="notice" class="py-5">
                        <h1 class="text-center text-blue"><strong style="font-size: calc(15px + 1vw);"><i
                                    class="fas fa-1x fa-bullhorn"></i>
                                ประชาสัมพันธ์</strong></h1>
                        <ul style="list-style: none;" class="px-5">
            @endif
            <li>
                <strong>
                    <a target="_blank"
                        @if ($download->link) href="{{ $download->link }}" @elseif($download->name_file) href="{{ Storage::url($download->path_file) }}" @endif
                        class="position-relative">
                        <span class="d-flex align-items-center">
                            <i class="fas fa-1x fa-bullhorn"></i>&nbsp;
                            <div class="text-ellipsis" title="{{ $download->name }}">{{ $download->name }}</div>
                            @if (countDate($download->created_at, 10, 'days'))
                                <div class="box-new">
                                    <span>ใหม่</span>
                                </div>
                            @endif
                        </span>
                        <span
                            class="notice-date position-absolute top-0 end-0">{{ thaiDateFormat($download->created_at, true) }}</span>
                    </a>

                </strong>
            </li>

            @if ($loop->last)
                </ul>
    </div>
    </div>
    @endif
@empty
    @endforelse
    @forelse ($lines as $key =>$line)
        @if ($loop->first)
            <div class="animate fade-left col-md-6">
                <div class="py-5 text-center">
                    <h1 class="text-center text-blue"><strong style="font-size: calc(15px + 1vw);"><i
                                class="fab fa-1x fa-line"></i>
                            LINE OPEN CHAT</strong></h1>
        @endif
        <img src="{{ Storage::url($line->line_path) }}" alt="LINE OPEN CHAT" width="150px">
        <a target="_blank" href="{{ $line->line_link }}" class="d-block text-green fw-bold">เข้าร่วม LINE OPEN CHAT</a>
        @if ($loop->last)
            </div>
            </div>
        @endif
    @empty
    @endforelse
    </div>

    <div style="overflow: hidden" class="bg-white">
        <div class="animate fade-up">
            <div id="poster2" class="container mb-5 pt-5">
                <div class="row m-0">
                    <div class="col-6 mx-auto">
                        <img style="box-shadow: 5px 5px 15px 0px #ccc!important;"
                            src="{{ asset('images/Poster-eddit.webp', env('REDIRECT_HTTPS')) }}" alt="banner"
                            width="100%">
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- End Poster -->

    <div class="bg-white p-5 text-center">
        <div style="overflow: hidden">
            <div class="animate grow">
                <div style="border-top: 5px solid var(--color-green);" class="mx-5"></div>
            </div>
        </div>
    </div>

    <!-- กำหนดการ -->
    <div class="bg-white">
        <div style="overflow: hidden">
            <div class="animate fade-right">
                <div class="position-relative w-50 w-md-100 me-auto">
                    <div
                        style="position: absolute; top: inherit; left: 0; z-index:1; border-bottom: 40px solid transparent; border-left: 40px solid #30ac33;">
                    </div>
                    <div
                        style="position: absolute; top: inherit; left: 0; z-index:1; border-bottom: 40px solid transparent; border-right: 40px solid #30ac33;">
                    </div>
                    <div class="row justify-content-center m-0 p-5">
                        <div class="col-md-10 w-100 rounded-0 px-3">
                            <div class="table-responsive-sm">
                                <table class="table caption-top">
                                    <caption>กำหนดการประชุมวิชาการระดับชาติ ราชภัฏเลยวิชาการ
                                    </caption>
                                    <thead>
                                        <tr>
                                            <th>ลำดับ</th>
                                            <th>กิจกรรม</th>
                                            <th>กำหนดเวลา</th>
                                            <th>หมายเหตุ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Call for paper</td>
                                            <td>ปัจจุบัน – 5 มกราคม 2566</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>วันสุดท้ายการชำระค่าลงทะเบียน</td>
                                            <td>ปัจจุบัน – 5 มกราคม 2566</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>ประกาศผลพิจารณา</td>
                                            <td>31 มกราคม 2566</td>
                                            <td><strong class="text-danger">เลื่อนเป็น 7 กุมภาพันธ์ 2566</strong></td>
                                        </tr>
                                        <tr>
                                            <td>4</td>
                                            <td>ปิดรับผลงานฉบับแก้ไข</td>
                                            <td>15 กุมภาพันธ์ 2566</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>5</td>
                                            <td>ลงทะเบียนเข้าร่วมงาน</td>
                                            <td>ปัจจุบัน – 24 กุมภาพันธ์ 2566</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>6</td>
                                            <td>ประกาศรายชื่อผู้เข้าร่วมงานทั้งหมด</td>
                                            <td>1 มีนาคม 2566</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>7</td>
                                            <td>นำเสนอผลงาน</td>
                                            <td>22 มีนาคม 2566</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>8</td>
                                            <td>เผยแพร่ Proceeding</td>
                                            <td>เมษายน 2566</td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>


                    <!-- <div class="container"><img src="./image/กำหนดการ.jpg" alt="plant" width="100%"></div> -->
                </div>
            </div>
        </div>
    </div>


    <div style="text-align:justify;" class="bg-light p-5">
        <!-- Content -->
        <div style="overflow: hidden">
            <div class="animate fade-left">
                <div class="box-blank"></div>
                <div class="position-relative w-50 w-md-100 ms-auto">
                    <div class="d-md-block d-none"
                        style="position: absolute; top:0; left: 0; border-left: 15px solid #ccc;height: 40px;z-index:2;">
                    </div>
                    <div class="d-md-block d-none"
                        style="position: absolute; top:45px; left: 0; border-left: 5px double #ccc;height: 100%;"></div>
                    {{-- <div
                        style="position: absolute; top: inherit; right: 0; z-index:1; border-bottom: 40px solid transparent; border-left: 40px solid #30ac33;">
                    </div>
                    <div
                        style="position: absolute; top: inherit; right: 0; z-index:1; border-bottom: 40px solid transparent; border-right: 40px solid #30ac33;">
                    </div> --}}

                    <div class="row justify-content-center m-0 px-3">
                        {{-- @for ($i = 0; $i <= 20; $i++)
                            <div class="position-absolute bg-white d-md-block d-none p-0"
                                style="left:-{{ $i * 5 }}%; width: 3px; height:100%;"></div>
                        @endfor --}}
                        <div style="word-wrap: break-word;" class="col-md-10 w-100 rounded-0">
                            <h1 class="animate delay-fade-right" style="color: #2cb0c0;">หลักการและเหตุผล</h1>
                            <p style="line-height: 25px;">
                                &emsp;ภายใต้สภาวการณ์โลกที่เต็มไปด้วยความผันผวน (Volatility) ความไม่แน่นอน (Uncertainty)
                                ความซับซ้อนสูง (Complexity) และความคลุมเครือยากที่จะคาดเดา (Ambiguity) หรือที่เรียกกันว่า
                                VUCA นั้น ส่งผลกระทบอย่างรุนแรงต่อยุทธศาสตร์การพัฒนาประเทศ
                                รัฐบาลไทยจึงดำเนินการปรับปรุงแผนการปฏิรูปประเทศเพื่อรับมือกับพลวัตการเปลี่ยนแปลงใน 13 ด้าน
                                ที่จะเน้นเฉพาะกิจกรรมสำคัญ (Big Rock)
                                ซึ่งประเด็นด้านเศรษฐกิจเป็นอีกประเด็นสำคัญที่จะช่วยพัฒนาประเทศให้มีความมั่นคง มั่งคั่ง
                                และยั่งยืน เพราะส่งผลกระทบสำคัญต่อความเป็นอยู่ของประชาชนในมิติต่าง ๆ ตามมาอีกด้วย
                                <br />&emsp;
                                แนวคิดหลักในการปฏิรูปประเทศด้านเศรษฐกิจมุ่งเน้นเสริมสร้างทักษะกำลังคนในระบบให้สอดคล้องกับความต้องการของภาคอุตสาหกรรม
                                และบริการมากกว่า 35 ล้านคนโดยมุ่งกระตุ้นรายได้เพิ่มขึ้นผ่านการสร้างเศรษฐกิจมูลค่าสูง (High
                                Value Economy) ด้วยฐานเกษตรชีวภาพ (Bio-economy) และการท่องเที่ยวคุณภาพสูง (High Value
                                Tourism) ซึ่งกระทรวงการอุดมศึกษา วิทยาศาสตร์ วิจัยและนวัตกรรม (อว.)
                                มีส่วนรับผิดชอบในการพัฒนาศักยภาพคนเพื่อเป็นพลังในการขับเคลื่อนเศรษฐกิจ
                                และส่งต่อเป็นหมุดหมายในการพลิกโฉมประเทศ และบรรจุในแผนพัฒนาเศรษฐกิจและสังคมแห่งชาติ ฉบับที่
                                13 เพื่อสร้างสังคมก้าวหน้า และขับเคลื่อนประเทศสู่เศรษฐกิจสร้างมูลค่าอย่างยั่งยืน
                                <br />&emsp; การวิจัย ซึ่งเป็นภารกิจหลักที่สำคัญของหน่วยงานภายใต้กระทรวงการอุดมศึกษา
                                วิทยาศาสตร์ วิจัยและนวัตกรรม จึงมีบทบาทสำคัญที่ไม่เพียงแต่สร้างองค์ความรู้ใหม่ ๆ
                                แต่ยังต้องพลิกโฉมงานวิจัยให้เกิดการสร้างเทคโนโลยี และนวัตกรรมพร้อมใช้
                                ที่จะช่วยยกระดับภาคการผลิต และอุตสาหกรรมตั้งแต่ต้นน้ำ กลางน้ำ
                                จนถึงปลายน้ำให้สามารถยกระดับมูลค่าการผลิตแบบเดิม ให้เกิดคุณค่าเพิ่ม
                                และสร้างมูลค่าเพิ่มได้ด้วยตัวชุมชน และวิสาหกิจขนาดกลางและขนาดย่อม
                                รวมถึงสร้างผู้ประกอบการใหม่ เพื่อสร้างรากฐานภาคการผลิต และการบริการให้เข้มแข็ง
                                พร้อมต่อยอดสู่การเป็นผู้ประกอบการที่จะสร้างผลกระทบทางเศรษฐกิจของประเทศในภาพรวมได้
                                <br />&emsp; ดังนั้น สถาบันวิจัยและพัฒนา มหาวิทยาลัยราชภัฏเลย
                                จึงได้จัดการประชุมวิชาการระดับชาติ ราชภัฏเลยวิชาการ ครั้งที่ 9 ประจำปี 2566 ขึ้น ภายใต้ชื่อ
                                “งานวิจัยเชิงพื้นที่เพื่อยกระดับเศรษฐกิจมูลค่าสูงของชุมชน” หรือ Area-based Research to
                                Strengthen the Community’s High Value Economy Conference 2023 ขึ้น
                                เพื่อเป็นเวทีในการนำเสนอผลงานวิชาการโดยแบ่งกลุ่มนำเสนอผลงานออกเป็น 5 กลุ่ม คือ 1)
                                กลุ่มมนุษยศาสตร์/สังคมศาสตร์ 2) กลุ่มครุศาสตร์ 3) กลุ่มวิทยาศาสตร์และเทคโนโลยี 4)
                                กลุ่มบริหารธุรกิจ บริการ และการท่องเที่ยว และ 5) กลุ่มวิศวกรรม และอุตสาหกรรม
                                โดยรูปแบบการนำเสนอผลงาน แบ่งเป็น ภาคบรรยาย (Oral Presentation) และภาคโปสเตอร์ (Poster
                                Presentation) ซึ่งผู้นำเสนอผลงานและผู้เข้าร่วมประชุม
                                จะได้ใช้เวทีนี้ในการแลกเปลี่ยนความรู้และต่อยอดงานวิจัยเพื่อประโยชน์ต่อสังคมโดยรวมต่อไป
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div style="text-align:justify;" class="bg-white">
        <!-- Content -->
        <div style="overflow: hidden">
            <div class="animate fade-right">
                <div class="position-relative w-50 w-md-100 me-auto">
                    <div
                        style="position: absolute; top: inherit; left: 0; z-index:1; border-bottom: 40px solid transparent; border-left: 40px solid #30ac33;">
                    </div>
                    <div
                        style="position: absolute; top: inherit; left: 0; z-index:1; border-bottom: 40px solid transparent; border-right: 40px solid #30ac33;">
                    </div>
                    <div class="row justify-content-center m-0 p-5">
                        <div style="word-wrap: break-word;" class="col-md-10 w-100 rounded-0 px-3">
                            <h1 style="color: #2cb0c0;">วัตถุประสงค์ของโครงการ</h1>
                            <p style="line-height: 25px;">1. เพื่อเป็นเวทีในการเผยแพร่ผลงานทางวิชาการของอาจารย์ นักวิจัย
                                นิสิต นักศึกษาในระดับอุดมศึกษาภายในและภายนอกมหาวิทยาลัย ตลอดจนหน่วยงานต่างๆ
                                <br /> 2. เพื่อเป็นการสนับสนุนการบูรณาการผลงานวิจัยไปสู่การสร้างนวัตกรรมและการพัฒนาชุมชน
                                สังคม
                                และประเทศชาติ
                                <br /> 3. เพื่อให้อาจารย์ นักวิจัย นิสิต
                                นักศึกษาในระดับอุดมศึกษาทั้งภายในและภายนอกมหาวิทยาลัย ตลอดจนหน่วยงานต่างๆ
                                ได้แลกเปลี่ยนเรียนรู้ และสร้างเครือข่ายทางวิชาการ
                            </p>

                            <h1 style="color: #2cb0c0;">เป้าหมายโครงการ</h1>
                            <p style="line-height: 25px;">คณาจารย์ นักวิจัย นิสิต นักศึกษา
                                ในระดับอุดมศึกษาบุคลากรจากหน่วยงานต่างๆ และผู้สนใจทั่วไป</p>

                            <h1 style="color: #2cb0c0;">ระยะเวลา</h1>
                            <p style="line-height: 25px;">วันพุธที่ 22 มีนาคม 2566</p>

                            <h1 style="color: #2cb0c0;">สถานที่จัดประชุมวิชาการ</h1>
                            <p style="line-height: 25px;">รูปแบบ Teleconference ผ่านระบบ Zoom Meeting และ Google Meet</p>


                            <h1 style="color: #2cb0c0;">รูปแบบการประชุม</h1>
                            <p style="line-height: 25px;">1. การบรรยายพิเศษ
                                <br /> 2. การนำเสนอผลงานวิชาการภาคบรรยาย (Oral Presentation)
                                <br /> 3. การนำเสนอผลงานวิชาการภาคโปสเตอร์ (Poster Presentation)
                                <br /> 4. การคัดเลือกบทความดีเด่น (Best paper)
                                <br /> 5. การจัดทำรายงานสืบเนื่องจากการประชุมวิชาการระดับชาติ (Proceedings)
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div style="text-align:justify;" class="bg-light p-5">
        <!-- Content -->
        <div style="overflow: hidden">
            <div class="animate fade-left">
                <div class="box-blank"></div>
                <div class="position-relative w-50 w-md-100 ms-auto">
                    <div class="d-md-block d-none"
                        style="position: absolute; top:0; left: 0; border-left: 15px solid #ccc;height: 40px; z-index:2;">
                    </div>
                    <div class="d-md-block d-none"
                        style="position: absolute; top:45px; left: 0; border-left: 5px double #ccc;height: 100%;"></div>
                    {{-- <div
                        style="position: absolute; top: inherit; right: 0; z-index:1; border-bottom: 40px solid transparent; border-left: 40px solid #30ac33;">
                    </div>
                    <div
                        style="position: absolute; top: inherit; right: 0; z-index:1; border-bottom: 40px solid transparent; border-right: 40px solid #30ac33;">
                    </div> --}}
                    <div class="row justify-content-center m-0 px-3">
                        {{-- @for ($i = 0; $i <= 20; $i++)
                            <div class="position-absolute bg-white d-md-block d-none p-0"
                                style="left:-{{ $i * 5 }}%; width: 3px; height:100%;"></div>
                        @endfor --}}
                        <div style="word-wrap: break-word;" class="col-md-10 w-100 rounded-0">
                            <h1 class="animate delay-fade-right" style="color: #2cb0c0;">
                                ลักษณะของผลงานและการแบ่งกลุ่มงานที่จะนำเสนอ</h1>
                            <strong style="color: brown;">การนำเสนอผลงานวิชาการมี 2 รูปแบบ</strong><br />
                            <p style="line-height: 25px;">
                                1. การนำเสนอผลงานในรูปแบบบรรยาย (Oral Presentation)
                                ใช้เวลาในการนำเสนอ เรื่องละไม่เกิน 20 นาที (รวมซักถาม 5 นาที) รูปแบบการจัดทำบทความฉบับเต็ม
                                (Full Paper) สามารถดาวน์โหลดได้ที่ https://conference.lru.ac.th/
                                <br />
                                2. การนำเสนอผลงานวิจัยในรูปแบบโปสเตอร์ (Poster Presentation)กว้าง 80 ซม. X สูง 120 ซม.
                                โดยจัดทำโปสเตอร์ตามรูปแบบที่กำหนดและอัดคลิปวิดีโอนำเสนอความยาวไม่เกิน 15 นาที
                                โดยสามารถดาวน์โหลด template ของโปสเตอร์ได้ที่ https://conference.lru.ac.th/
                                <br />
                                <strong style="color: brown;">การจัดทำโปสเตอร์ประกอบด้วยหัวข้อต่อไปนี้</strong><br />
                                1) ชื่อเรื่อง ภาษาไทย (จัดให้อยู่กึ่งกลางหน้ากระดาษ)
                                <br /> 2) ชื่อผู้วิจัย ภาษาไทย (จัดให้อยู่กึ่งกลางหน้ากระดาษ)
                                <br /> 3) บทนำ
                                <br /> 4) วัตถุประสงค์
                                <br /> 5) วิธีดำเนินการวิจัย
                                <br /> 6) ผลการวิจัย
                                <br /> 7) ข้อเสนอแนะ
                                <br /> 8) เอกสารอ้างอิง (เฉพาะที่อ้างอิงในโปสเตอร์นี้)
                                <br />
                                <strong style="color: brown;">* โดยผลงานวิชาการข้างต้นจะต้อง</strong>
                                <br /> 1. เป็นผลงานใหม่ที่ยังไม่เคยเผยแพร่ที่ใดมาก่อน
                                <br /> 2. มีหัวข้อเกี่ยวข้องกับสาขาวิชาต่าง ๆ ดังนี้
                                <br /> 1) กลุ่มมนุษยศาสตร์/สังคมศาสตร์
                                <br /> 2) กลุ่มครุศาสตร์
                                <br /> 3) กลุ่มวิทยาศาสตร์และเทคโนโลยี
                                <br /> 4) กลุ่มบริหารธุรกิจ การบริการ และการท่องเที่ยว
                                <br /> 5) กลุ่มวิศวกรรม และอุตสาหกรรม
                                <br />
                                <strong style="color: brown;">การเตรียมบทความวิจัย/วิทยานิพนธ์</strong>
                                <br />
                                ความยาวไม่เกิน 7-12 หน้า ชนิดอักษร TH Saraban New หรือ TH Saraban PSK โดยใช้ขนาดตัวอักษร 14
                                ปกติ ประกอบหัวข้อ
                                <br />(1) ชื่อเรื่องภาษาไทยและภาษาอังกฤษ
                                <br />(2) ชื่อผู้เขียน
                                <br />(3) บทคัดย่อภาษาไทยและคำสำคัญ
                                <br />(4) บทคัดย่อภาษาอังกฤษ (Abstract) และ Keywords
                                <br />(5) ความเป็นมาของปัญหา
                                <br />(6) วัตถุประสงค์ของการวิจัย
                                <br />(7) วิธีดําเนินการวิจัย
                                <br />(8) ผลการวิจัย
                                <br />(9) อภิปรายผล
                                <br />(10) สรุปผลการวิจัย
                                <br />(11) ข้อเสนอแนะ
                                <br />(12) เอกสารอ้างอิง (เฉพาะที่อ้างอิงในบทความนี้)
                                <br />
                                <strong style="color: brown;">การเตรียมบทความวิชาการ</strong>
                                <br /> ความยาวไม่เกิน 7-12 หน้า ชนิดอักษร TH Saraban New หรือ TH SarabanPSK
                                โดยใช้ขนาดตัวอักษร 14 ปกติ ประกอบหัวข้อ
                                <br />(1) ชื่อเรื่อง ภาษาไทยและภาษาอังกฤษ
                                <br />(2) ชื่อผู้เขียน
                                <br />(3) บทคัดย่อภาษาไทยและคำสำคัญ
                                <br />(4) บทคัดย่อภาษาอังกฤษ (Abstract) และ Keywords
                                <br />(5) บทนำ
                                <br />(6) เนื้อหา
                                <br />(7) บทสรุป
                                <br />(8) เอกสารอ้างอิง (เฉพาะที่อ้างอิงในในบทความนี้)
                            </p>
                        </div>
                    </div>
                </div>

            </div><!-- Content -->
        </div>
    </div>

    <div style="text-align:justify;" class="bg-white">
        <div style="overflow: hidden">
            <div class="animate fade-right">
                <div class="position-relative w-100 w-md-100 me-auto">
                    <div
                        style="position: absolute; top: inherit; left: 0; z-index:1; border-bottom: 40px solid transparent; border-left: 40px solid #30ac33;">
                    </div>
                    <div
                        style="position: absolute; top: inherit; left: 0; z-index:1; border-bottom: 40px solid transparent; border-right: 40px solid #30ac33;">
                    </div>
                    <div class="row justify-content-center m-0 p-5">
                        <div style="word-wrap: break-word;" class="col-md-10 w-100 rounded-0 px-3">
                            <h1 style="color: #2cb0c0;">ผลที่คาดว่าจะได้รับ</h1>
                            <p style="line-height: 25px;">
                                1. มีการเผยแพร่ผลงานทางวิชาการของอาจารย์ นักวิจัย นิสิต
                                นักศึกษาในระดับอุดมศึกษาจากภายในและภายนอกมหาวิทยาลัย และบุคลากรจากหน่วยงานต่างๆ
                                <br /> 2. ผลงานวิจัยและผลงานทางวิชาการในรูปแบบต่างๆ ได้รับการถ่ายทอด และแลกเปลี่ยนเรียนรู้
                                และสามารถนำไปต่อยอดทั้งในเชิงวิชาการ และการนำไปใช้ประโยชน์ต่อชุมชน และสังคม
                                <br /> 3. อาจารย์ นักวิจัย นิสิต นักศึกษาในระดับอุดมศึกษาจากภายในและภายนอกมหาวิทยาลัย
                                และบุคลากรจากหน่วยงานต่างๆ ได้ร่วมแลกเปลี่ยนเรียนรู้ผลงานทางวิชาการ
                                <br /> 4. เกิดเครือข่ายนักวิจัยในระดับชาติ
                            </p>


                            <h1 style="color: #2cb0c0;">การจัดเตรียมบทความฉบับเต็ม (Full Paper)</h1>
                            <p style="line-height: 25px;">
                                1. การส่งต้นฉบับ ผู้นำเสนอจะต้องส่งต้นฉบับแบบพิมพ์ในรูปแบบของอิเล็กทรอนิกส์ไฟล์นามสกุล
                                “.doc” (MS Word) และ “.pdf” (PDF) ทางเว็บไซต์ <a href="https://conference.lru.ac.th/"
                                    class="text-green">https://conference.lru.ac.th/</a> ดังต่อไปนี้
                                <br /> &emsp; 1.1 ไฟล์บทความฉบับเต็ม (MS Word)
                                <br /> &emsp; 1.2 ไฟล์บทความฉบับเต็มที่ไม่ระบุชื่อสกุลและหน่วยงานที่สังกัดของผู้แต่ง (PDF)
                                (เพื่อส่งให้ผู้ทรงคุณวุฒิพิจารณาบทความ)
                                <br /> 2. ผู้นำเสนอผลงาน สามารถดาวน์โหลดรูปแบบการจัดทำบทความฉบับเต็ม (Full Paper) ได้ที่
                                <a href="https://conference.lru.ac.th/"
                                    class="text-green">https://conference.lru.ac.th/</a>
                            </p>

                            <h1 style="color: #2cb0c0;">การพิจารณาผลงาน</h1>
                            <p style="line-height: 25px;">
                                1. พิจารณาการเลือกกลุ่มการนำเสนอผลงานและประเภทของการนำเสนอผลงาน
                                <br />2. พิจารณาผลงานโดยผู้ทรงคุณวุฒิอย่างน้อย 2 ท่าน
                                และประเมินบทความตามเกณฑ์และแบบฟอร์มที่กำหนด
                                <br />3. พิจารณาคัดเลือกผลงานวิจัยที่จะนำเสนอในการประชุม
                                และที่จะรวบรวมเป็นรายงานสืบเนื่องจากการประชุมวิชาการระดับชาติ Proceedings
                                <br />4. พิจารณามอบเกียรติบัตรให้แก่ผู้ได้รับการคัดเลือกบทความระดับดีเด่น
                                โดยกรรมการผู้ทรงคุณวุฒิร่วมประเมินผลงานที่นำเสนอทั้งภาคบรรยาย (Oral Presentation)
                                และภาคโปสเตอร์ (Poster Presentation)
                            </p>

                            <h1 style="color: #2cb0c0;">
                                การตีพิมพ์รายงานสืบเนื่องจากการประชุมวิชาการระดับชาติ (Proceedings) และเกียรติบัตร
                            </h1>
                            <p style="line-height: 25px;">
                                1. ผลงานที่ตีพิมพ์ในรายงานสืบเนื่องจากการประชุมวิชาการระดับชาติ
                                ทุกผลงานจะต้องผ่านกระบวนการร่วมนำเสนอในงานประชุมวิชาการ
                                หากผู้นำเสนอผลงานไม่ส่งคลิปนำเสนอและไม่เข้าร่วมกระบวนการในการนำเสนอผลงาน
                                บทความของท่านจะไม่ได้รับการตีพิมพ์ในรายงานสืบเนื่องจากการประชุมวิชาการในครั้งนี้
                                <br />2. บทความที่ตีพิมพ์ในรายงานสืบเนื่องจากการประชุมวิชาการระดับชาติ (Proceeding)
                                ทางผู้จัดการประชุมจะดำเนินการขอรหัสตัวระบุวัตถุดิจิตอล (DOI) ทุกบทความ
                                หากเจ้าของบทความไม่ประสงค์ให้มีเลขที่ DOI ให้แจ้งมายังผู้จัดการประชุมเป็นลายลักษณ์อักษร
                                มาที่ E-Mail: <a href="mailto:lruconference2023@gmail.com"
                                    class="text-green">lruconference2023@gmail.com</a>
                                <br />3. สำหรับผู้เข้าร่วมการนำเสนอผลงานทุกท่านจะได้รับเกียรติบัตรการนำเสนอผลงาน
                                ซึ่งสามารถดาวน์โหลดได้ผ่านทาง <a href="https://conference.lru.ac.th/"
                                    class="text-green">https://conference.lru.ac.th/</a> ตั้งแต่วันที่ 1
                                เมษายน 2566
                                เป็นต้นไป
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <br />
    <!-- End Content -->
@endsection
