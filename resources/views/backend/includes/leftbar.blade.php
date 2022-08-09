<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-light-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
        <img src="{{ asset('images/logo.webp', env('REDIRECT_HTTPS')) }}" alt="AdminLTE Logo" class="brand-image">
        <span>ราชภัฏเลยวิชาการ</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar" id="navbar-conference-backend">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="info">
                <a href="#" class="d-block">ADMIN</a>
            </div>
        </div>


        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
           with font-awesome or any other icon font library -->
                <li class="nav-header">แผงควบคุม</li>
                <li class="nav-item">
                    <a href="/" class="nav-link text-info">
                        <i class="nav-icon fas fa-home"></i>
                        <p>เว็บไซต์ประชุมวิชาการ</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('backend.dashboard.index') }}"
                        class="nav-link @if (Request::is('backend/dashboard')) active @endif">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>หน้าแรก</p>
                    </a>
                </li>
                @auth
                    @if (auth()->user()->is_admin === 2)
                        <li class="nav-item">
                            <a href="{{ route('backend.conference.index') }}"
                                class="nav-link @if (Request::is('backend/conference')) active @endif">
                                <i class="nav-icon fas fa-th"></i>
                                <p>หัวข้อ</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('backend.manuals.index') }}"
                                class="nav-link @if (Request::is('backend/manuals')) active @endif">
                                <i class="nav-icon fas fa-book"></i>
                                <p>คู่มือ</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('backend.downloads.index') }}"
                                class="nav-link @if (Request::is('backend/downloads')) active @endif">
                                <i class="nav-icon fas fa-download"></i>
                                <p>ดาวน์โหลด & ประชาสัมพันธ์</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('backend.users.index') }}"
                                class="nav-link @if (Request::is('backend/users')) active @endif">
                                <i class="nav-icon fas fa-user"></i>
                                <p>ผู้ใช้งาน</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('backend.lines.index') }}"
                                class="nav-link @if (Request::is('backend/lines')) active @endif">
                                <i class="nav-icon fab fa-line"></i>
                                <p>Line Openchat</p>
                            </a>
                        </li>
                    @endif
                @endauth

                <li class="nav-item">
                    <a href="{{ route('backend.researchs.index') }}"
                        class="nav-link @if (Request::is('backend/researchs')) active @endif">
                        <i class="nav-icon fas fa-book"></i>
                        <p>บทความทั้งหมด</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('backend.research.index') }}"
                        class="nav-link @if (Request::is('backend/researchs/management')) active @endif">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>จัดการบทความ</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('backend.research.first.index') }}"
                        class="nav-link @if (Request::is('backend/researchs/management/times/1')) active @endif">
                        <i class="nav-icon fas fa-book-open"></i>
                        <p>บทความฉบับแก้ไขครั้งที่ 1</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('backend.research.second.index') }}"
                        class="nav-link @if (Request::is('backend/researchs/management/times/2')) active @endif">
                        <i class="nav-icon fas fa-book-open"></i>
                        <p>บทความฉบับแก้ไขครั้งที่ 2</p>
                    </a>
                </li>
                <li class="nav-item @if (Request::is('backend/posters') || Request::is('backend/orals')) menu-is-opening menu-open @endif">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-chart-line"></i>
                        <p>
                            จัดการผลงานนำเสนอ
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="pages/forms/general.html"
                                class="nav-link @if (Request::is('backend/orals')) active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>ผลงานนำเสนอ Oral</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('backend.posters.index') }}"
                                class="nav-link @if (Request::is('backend/posters')) active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>ผลงานนำเสนอ Poster</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-edit"></i>
                        <p>
                            Proceedings
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @forelse ($conferences = DB::table('conferences')->select('year')->orderBy('year', 'desc')->get() as $conference)
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>{{ $conference->year }}</p>
                                </a>
                            </li>

                        @empty
                        @endforelse
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
