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
                    <li class="nav-item dropdown" id="downloads">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            ดาวน์โหลด
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <div class="line-dropdown"></div>
                            @if ($downloads = DB::table('downloads')->select(
                                    'downloads.id as id',
                                    'downloads.name as name',
                                    'downloads.link as link',
                                    'downloads.name_file as name_file',
                                    'downloads.path_file as path_file',
                                    'downloads.ext_file as ext_file',
                                    'downloads.conference_id as conference_id',
                                    'downloads.created_at as created_at',
                                    'downloads.updated_at as updated_at')->leftjoin('conferences', 'conferences.id', '=', 'downloads.conference_id')->where('conferences.status', 1)->get())
                                @forelse ($downloads as $download)
                                    <li><a target="_blank" class="dropdown-item"
                                            @if ($download->link) href="{{ $download->link }}" @elseif($download->name_file) href="{{ Storage::url($download->path_file) }}" @endif>{{ $download->name }}
                                            @if (countDate($download->created_at, 10, 'days'))
                                                <div class="box-new">
                                                    <span>ใหม่</span>
                                                </div>
                                            @endif
                                        </a>
                                    </li>
                                @empty
                                    <li>
                                        <a class="dropdown-item disabled" href="#">ไม่มีรายการดาวน์โหลด</a>
                                    </li>
                                @endforelse
                            @endif
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Proceedings
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="{{ route('list.research.index') }}">Proceeding 2565</a>
                            </li>
                            <li><a class="dropdown-item" href="{{ route('list.attend.index') }}">Proceeding 2564</a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            รายชื่อ
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="{{ route('list.research.index') }}">รายชื่อบทความ</a></li>
                            <li><a class="dropdown-item" href="{{ route('list.attend.index') }}">รายชื่อผู้ลงทะเบียน</a>
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
                                    @if ($conference = DB::table('conferences')->select('id')->where('status', 1)->where('status_research_edit_two', 1)->first())
                                        <a class="dropdown-item {{ Request::is('employee/research/send-edit-2/show/*') ? 'active' : '' }}"
                                            aria-current="page"
                                            href="{{ route('employee.research.send.two.edit', auth()->user()->id) }}">ส่งบทความฉบับแก้ไขครั้งที่
                                            2</a>
                                    @endif


                                </li>

                                <li>
                                    <a class="dropdown-item {{ Request::is('employee/research/uploadfile/*') ? 'active' : '' }}"
                                        aria-current="page"
                                        href="{{ route('employee.research.uploadfile', auth()->user()->id) }}">อัพโหลดลิงค์วิดีโอและไฟล์โปสเตอร์</a>
                                </li>

                            </ul>
                        </li>
                    @endguest

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            นำเสนอ
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li>
                                <a class="dropdown-item {{ Request::is('employee/research/send') ? 'active' : '' }}"
                                    aria-current="page" href="#">ลิงค์นำเสนอผลงาน Oral</a>
                            </li>

                            <li>
                                <a class="dropdown-item {{ Request::is('employee/research/send') ? 'active' : '' }}"
                                    aria-current="page" href="#">ผลงานนำเสนอ Oral</a>
                            </li>

                            <li>
                                <a class="dropdown-item {{ Request::is('posters') ? 'active' : '' }}"
                                    aria-current="page" href="{{ route('posters.index') }}">ผลงานนำเสนอ Poster</a>
                            </li>

                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('payment') ? 'active' : '' }}" aria-current="page"
                            href="{{ route('payment') }}">วิธีชำระเงิน</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('contract') ? 'active' : '' }}" aria-current="page"
                            href="{{ route('contract') }}">ติดต่อ</a>
                    </li>
                    @auth
                        @if (auth()->user()->is_admin === 2 || auth()->user()->is_admin === 1)
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
                        <button type="submit" class="btn rounded-0 btn-danger text-white mx-3"><i
                                class="fas fa-sign-out"></i>
                            ออกจากระบบ</button>
                    </form>
                @endguest
            </div>
        </div>
    </nav>
    <!-- End Navbar -->
@endsection
