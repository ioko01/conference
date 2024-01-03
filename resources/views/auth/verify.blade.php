@extends('frontend.layouts.verify_email')

@section('content')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    @if (auth()->user()->position_id == 4)
                        <div class="card-header">{{ __('กำลังตรวจสอบ') }}</div>

                        <div class="card-body text-center">
                            <br />
                            <div class="col-md-3 col-6 mx-auto">
                                <img src="{{ asset('images/wall-clock.webp', env('REDIRECT_HTTPS')) }}" alt="email"
                                    width="100%">

                            </div>
                            <br />
                            <div class="col-12">
                                <h1>กำลังตรวจสอบข้อมูลของท่าน กรุณารอสักครู่</h1>
                                <h1>ติดต่อเจ้าหน้าที่โทร: 0-4283-5224-8 ต่อ 41141-2, 51143</h1>
                            </div>

                            <div class="d-inline">
                                <a href="/" class="btn btn-lg btn-warning text-white w-100 rounded-0"
                                    onclick="thisDisabled(this)">กลับไปยังหน้าแรก</a>
                            </div>

                        </div>
                    @else
                        <div class="card-header">{{ __('ยืนยันอีเมล') }}</div>

                        <div class="card-body text-center">
                            <div class="col-md-3 col-6 mx-auto">
                                <img src="{{ asset('images/mail.webp', env('REDIRECT_HTTPS')) }}" alt="email"
                                    width="100%">

                            </div>
                            <div class="col-12">
                                <h1>กรุณายืนยันตัวตนที่อีเมล</h1>
                                <h1>{{ auth()->user()->email }}</h1>
                            </div>
                            @if (session('resent'))
                                <div class="alert alert-success" role="alert">
                                    {{ __('รหัสยืนยันอีเมลถูกส่งไปยังอีเมล') }}
                                    {{ auth()->user()->email }}
                                    {{ __('กรุณาเช็คอีเมลของท่าน') }}
                                </div>
                            @endif

                            <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                                @csrf
                                <button onclick="thisDisabled(this);open_loading_modal('#modal', 'lg', 'กำลังโหลด', 'กำลังส่งอีเมล กรุณารอสักครู่ (อาจใช้เวลานานถึง 5 นาที)')" type="submit"
                                    class="btn btn-lg btn-success w-100 rounded-0 my-2">คลิกที่นี่เพื่อส่งรหัสอีกครั้ง</button>
                                <a href="/" class="btn btn-lg btn-warning text-white w-100 rounded-0"
                                    onclick="thisDisabled(this)">กลับไปยังหน้าแรก</a>
                            </form>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
    <div id="modal"></div>
@endsection
