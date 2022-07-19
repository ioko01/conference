@extends('frontend.layouts.master_frontend')

@section('content')
    <!-- Content -->
    <div class="bg-white text-blue p-5 my-5">
        <div class="inner-content-header">
            <h2 class="text-center">ผลงานนำเสนอ Poster ในงานการประชุมวิชาการ ราชภัฏเลยวิชาการ ครั้งที่ 8</h2>
            <h4 class="text-green py-3">
                LRU Conference 2022
            </h4>
        </div>

        <div>
            <h1>การนำเสนอผลงาน Poster Presentation</h1>
        </div>

        <div id="poster" class="row my-5">
            <div class="col-lg-2 col-md-4 col-sm-6 my-3">
                <div style="width: 90%;" class="animated fade-up card rounded-0 mx-auto">
                    <div class="card-content w-100 h-100">
                        <div class="card-header text-center bg-white">
                            <h2>P-ED 01</h2>
                        </div>
                        <div style="clip-path: inset(0px 0px);" class="card-body position-relative p-0">
                            <div class="img-expand-hover">
                                <i class="fas fa-3x fa-search-plus text-white"> <span
                                        class="text-xl">ดูภาพขนาดใหญ่</span></i>
                            </div>
                            <img width="100%"
                                src="{{ asset('images/poster2022-149.jpg', env('REDIRECT_HTTPS')) }}" alt="">
                        </div>
                        <div class="card-footer bg-white">
                            <p>ลิงค์: <br /><a target="_blank"
                                    href="https://drive.google.com/file/d/1d31F8ZyD6665u516aoIUp4wWVUkqAvW1/view?usp=sharing">https://drive.google.com/file/d/1d31F8ZyD6665u516aoIUp4wWVUkqAvW1/view?usp=sharing</a>
                            </p>
                            <p>ชื่อบทความ: <br />การพัฒนาทักษะการอ่านและการเขียนคำคล้องจอง โดยใช้ชุดฝึกเสริมทักษะ
                                สำหรับนักเรียน
                                ชั้นประถมศึกษาปีที่ 2 โรงเรียนบ้านนาสีสลากกินแบ่งสงเคราะห์ 59
                                สำนักงานเขตพื้นที่การศึกษาประถมศึกษาเลย เขต 1</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- End Content -->
    <div id="modal_poster"></div>
@endsection
