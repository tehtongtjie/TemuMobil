<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/dashboard') }}">
        <img src="{{ asset('img/logo.png') }}" alt="Logo" width="50" height="30">
        <div class="sidebar-brand-text mx-3">TemuMobil</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('/dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Manajemen Data
    </div>

    <!-- Nav Item - Manajemen Pengguna -->
    <li class="nav-item {{ request()->is('users*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('/users') }}">
            <i class="fas fa-fw fa-user"></i>
            <span>Manajemen Pengguna</span>
        </a>
    </li>

    <!-- Nav Item - Manajemen Mobil -->
    <li class="nav-item {{ request()->is('mobil*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('/mobil') }}">
            <i class="fas fa-fw fa-car"></i>
            <span>Manajemen Mobil</span>
        </a>
    </li>

    <!-- Nav Item - Manajemen Inspeksi -->
    <li class="nav-item {{ request()->is('inspeksi*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('/inspeksi') }}">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Manajemen Inspeksi</span>
        </a>
    </li>

    <!-- Nav Item - Manajemen Konten -->
    <li class="nav-item {{ request()->is('konten*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('/konten') }}">
            <i class="fas fa-fw fa-globe"></i>
            <span>Manajemen Konten</span>
        </a>
    </li>

    <!-- Nav Item - Manajemen Transaksi -->
    <li class="nav-item {{ request()->is('transaksi*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('/transaksi') }}">
            <i class="fas fa-fw fa-wallet"></i>
            <span>Manajemen Transaksi</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
