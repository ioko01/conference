@section('navbar-topbar')
<!-- Navbar -->
<nav class="navbar navbar-expand-lg shadow-sm bg-white">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('welcome') }}">
            <img src="{{ asset('images/logo.png')}}" alt="logo" width="130">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="navbar-toggler-icon fas fa-bars text-green"></i>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
            <ul class="navbar-nav mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('/') ? 'active' : '' }}" aria-current="page"
                        href="{{ route('welcome') }}">หน้าหลัก</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        ดาวน์โหลด
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <div class="line-dropdown"></div>
                        <li><a class="dropdown-item" href="#">เทมเพลตบทความวิจัยและวิทยานิพนธ์</a></li>
                        <li><a class="dropdown-item" href="#">เทมเพลตบทความวิชาการ</a>
                        </li>
                        <li><a class="dropdown-item" href="#">กำหนดการ</a>
                        </li>
                        <li><a class="dropdown-item" href="#">โครงการ</a>
                        </li>
                        <li><a class="dropdown-item"
                                href="./files/ประวัติ ดร. เธียรไชย ยักทะวงษ 2564.pdf">ประวัติวิทยากร</a></li>
                        <li><a class="dropdown-item" href="#">แนวทางการจัดประชุมออนไลน์</a></li>
                        <li><a class="dropdown-item" href="#">ผลพิจารณาแบบตอบรับ</a></li>
                        <li><a class="dropdown-item" href="#">Proceeding</a></li>
                        <li><a class="dropdown-item" href="#">คู่มือการเข้าร่วมประชุมวิชาการ</a>
                        </li>
                    </ul>
                </li>

                @guest
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        ลงทะเบียน
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="{{ route('register')}}">สมัครเข้าใช้งานระบบ</a></li>
                    </ul>

                </li>
                @else
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('employee*') ? 'active' : ''}}" aria-current="page" href="@guest
                    {{ route('login') }}
                    @else
                    {{ route('employee.research.index') }}
                @endguest">ส่งบทความ</a>
                    @endguest


                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        รายชื่อ
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#">รายชื่อบทความ</a></li>
                        <li><a class="dropdown-item" href="#">รายชื่อผู้ร่วมงาน</a></li>
                    </ul>
                </li>
                @auth
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="{{ route('welcome') }}">บทความของฉัน</a>
                </li>
                @endauth

                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="#">วิธีชำระเงิน</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="#">ติดต่อ</a>
                </li>
            </ul>
            @guest
            <a href="{{ route('login')}}" class="btn rounded-0 btn-green text-white mx-3">เข้าสู่ระบบ</a>
            @else
            <form action="{{route('logout')}}" method="post">
                @csrf
                <button type="submit" class="btn rounded-0 btn-danger text-white mx-3">ออกจากระบบ</button>
            </form>
            @endguest
        </div>
    </div>
</nav>
<!-- End Navbar -->
@endsection