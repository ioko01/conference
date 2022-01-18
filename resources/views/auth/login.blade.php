@extends('frontend.layouts.master_frontend')

@section('content')
<!-- Form Login -->
<div class="container-md mx-auto m-5 p-5">
    <div class="row text-center">
        <div id="text-login" class="col-md-5 text-white bg-green rounded-start py-3 d-none d-sm-block">
            <div class="d-flex justify-content-center flex-column h-100">
                <h1 style="font-size: 50px;">ยินดีต้อนรับ</h1>
                <h4 style="font-size: 18px;">สู่การประชุมวิชาการระดับชาติ<br />ราชภัฏเลยวิชาการ ครั้งที่ 8</h4>
                <div style="border-bottom: 2px solid white;" class="mx-5 d-none d-md-block"></div>
            </div>
        </div>
        <div class="col-md-7 text-dark bg-white rounded-end px-4">
            <h1 class="py-5">เข้าใช้งานระบบ</h1>
            <form action="{{ route('login') }}" method="POST">
                @csrf

                <div class="mb-4 text-start">
                    <label for="email" class="form-label">E-Mail</label>
                    <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                        value="{{ old('email') }}" autocomplete="email" autofocus>

                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="mb-4 text-start">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                        name="password">

                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="d-block mb-4">
                    <button type="submit" class="btn btn-login w-100 py-2 rounded-0">ล็อกอินเข้าใช้งานระบบ</button>
                </div>
                <div class="mb-4">
                    <a href="./forgotpassword.html">ลืมรหัสผ่าน</a> / <a
                        href="./changepassword.html">เปลี่ยนรหัสผ่าน</a>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Form Login -->
@endsection