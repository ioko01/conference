<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <div class="navbar-nav ml-auto">
        <form action="{{ route('logout') }}" method="post">
            @csrf
            <button type="submit" class="btn rounded-0 btn-danger text-white mx-3">ออกจากระบบ</button>
        </form>
    </div>
</nav>
<!-- /.navbar -->
