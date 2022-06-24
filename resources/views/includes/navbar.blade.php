@section('navbar-topbar')
    <!-- Navbar -->
    <nav id="navbar-conference" class="navbar navbar-expand-lg shadow-sm bg-white">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('welcome') }}">
                <img src="{{ asset('images/logo.png', env('REDIRECT_HTTPS')) }}" alt="logo" width="130">
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
                            @if (DB::table('downloads')->get())
                                @foreach (DB::table('downloads')->get() as $download)
                                    <li><a target="_blank" class="dropdown-item"
                                            @if ($download->link) href="{{ $download->link }}" @elseif($download->name_file) href="{{ Storage::url($download->path_file) }}" @endif>{{ $download->name }}</a>
                                    </li>
                                @endforeach
                            @endif


                            {{-- <li><a class="dropdown-item"
                                    href="./files/ประวัติ ดร. เธียรไชย ยักทะวงษ 2564.pdf">ประวัติวิทยากร</a></li>
                            <li><a class="dropdown-item" href="#">แนวทางการจัดประชุมออนไลน์</a></li>
                            <li><a class="dropdown-item" href="#">ผลพิจารณาแบบตอบรับ</a></li>
                            <li><a class="dropdown-item" href="#">Proceeding</a></li>
                            <li><a class="dropdown-item" href="#">คู่มือการเข้าร่วมประชุมวิชาการ</a>
                            </li> --}}
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            รายชื่อ
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="{{ route('list.research.index') }}">รายชื่อบทความ</a></li>
                            <li><a class="dropdown-item" href="{{ route('list.attend.index') }}">รายชื่อผู้ร่วมงาน</a>
                            </li>
                        </ul>
                    </li>

                    @guest
                        <li class="nav-item">
                        <li><a class="nav-link {{ Request::is('register') ? 'active' : '' }}" aria-current="page"
                                href="{{ route('register') }}">ลงทะเบียน</a></li>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                บทความ
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li>
                                    <a class="dropdown-item {{ Request::is('employee/research/send') ? 'active' : '' }}"
                                        aria-current="page"
                                        href="@guest
                                                                                {{ route('login') }}
@else
{{ route('employee.research.index') }}
                                                            @endguest">ส่งบทความ</a>
                                </li>

                                <li>
                                    <a class="dropdown-item {{ Request::is('employee/research/show/*') ? 'active' : '' }}"
                                        aria-current="page"
                                        href="{{ route('employee.research.show', auth()->user()->id) }}">บทความของฉัน</a>
                                </li>

                                <li>
                                    <a class="dropdown-item {{ Request::is('employee/research/send-edit/show/*') ? 'active' : '' }}"
                                        aria-current="page"
                                        href="{{ route('employee.research.send.edit', auth()->user()->id) }}">ส่งบทความฉบับแก้ไขครั้งที่
                                        1</a>
                                </li>

                                <li>
                                    <a class="dropdown-item {{ Request::is('employee/research/send-edit-2/show/*') ? 'active' : '' }}"
                                        aria-current="page"
                                        href="{{ route('employee.research.send.two.edit', auth()->user()->id) }}">ส่งบทความฉบับแก้ไขครั้งที่
                                        2</a>
                                </li>

                                <li>
                                    <a class="dropdown-item {{ Request::is('employee/research/video/*') ? 'active' : '' }}"
                                        aria-current="page"
                                        href="{{ route('employee.research.video', auth()->user()->id) }}">อัพโหลดลิงค์วิดีโอ</a>
                                </li>

                            </ul>
                        </li>
                    @endguest

                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('payment') ? 'active' : '' }}" aria-current="page"
                            href="{{ route('payment') }}">วิธีชำระเงิน</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('contract') ? 'active' : '' }}" aria-current="page"
                            href="{{ route('contract') }}">ติดต่อ</a>
                    </li>
                    @auth
                        @if (auth()->user()->is_admin === 2)
                            <li class="nav-item">
                                <a style="color: sandybrown!important;" class="nav-link" aria-current="page"
                                    href="{{ route('backend.dashboard.index') }}">แผงควบคุม</a>
                            </li>
                        @endif
                    @endauth
                </ul>
                @guest
                    <a href="{{ route('login') }}" class="btn rounded-0 btn-green text-white mx-3"><i
                            class="fas fa-sign-in"></i> เข้าสู่ระบบ</a>
                @else
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button type="submit" class="btn rounded-0 btn-danger text-white mx-3"><i class="fas fa-sign-out"></i>
                            ออกจากระบบ</button>
                    </form>
                @endguest
            </div>
        </div>
    </nav>
    <!-- End Navbar -->
@endsection
