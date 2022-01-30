@extends('frontend.layouts.master_frontend')

@section('content')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('กรุณายืนยันอีเมล') }}</div>

                    <div class="card-body">
                        @if (session('resent'))
                            <div class="alert alert-success" role="alert">
                                {{ __('รหัสยืนยันอีเมลถูกส่งเรียบร้อยแล้ว กรุณาเช็คอีเมลของท่าน') }}
                            </div>
                        @endif

                        {{ __('กรุณายืนยันอีเมลก่อนทำรายการนี้') }}
                        {{ __('หากคุณยังไม่ยืนยันอีเมล') }},
                        <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                            @csrf
                            <button type="submit"
                                class="btn btn-link p-0 m-0 align-baseline">{{ __('กรุณาคลิกที่นี่เพื่อส่งรหัสยืนยันอีเมล') }}</button>.
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
