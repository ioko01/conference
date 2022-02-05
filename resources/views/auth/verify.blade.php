@extends('frontend.layouts.verify_email')

@section('content')

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">{{ __('ยืนยันอีเมล') }}</div>

                <div class="card-body text-center">
                    <div class="col-md-3 col-6 mx-auto">
                        <img src="{{ secure_asset('images/mail.png') }}" alt="email" width="100%">

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
                        <button type="submit"
                            class="btn btn-lg btn-dark w-100 rounded-0">คลิกที่นี่เพื่อส่งรหัสอีกครั้ง</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection