<style>
    /* Custom Sidebar Styling */
    .sidebar {
        background: linear-gradient(180deg, #1e3c72 0%, #2a5298 100%) !important;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .sidebar-brand {
        padding: 1.5rem 1rem;
        transition: all 0.3s ease;
        text-decoration: none !important;
    }

    .sidebar-brand:hover {
        background: rgba(255, 255, 255, 0.1);
        transform: translateY(-2px);
    }

    .sidebar-brand-icon {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }

    .sidebar-brand-icon i {
        font-size: 1.5rem;
        color: white;
    }

    .sidebar-brand-text {
        color: white !important;
        font-weight: 700;
        font-size: 1.2rem;
        line-height: 1.2;
    }

    .sidebar-brand-text .user-info {
        font-size: 0.75rem;
        opacity: 0.8;
        font-weight: 400;
        margin-top: 0.25rem;
    }

    .sidebar-divider {
        border-color: rgba(255, 255, 255, 0.15) !important;
        margin: 1rem 0;
    }

    .sidebar-heading {
        font-size: 0.75rem;
        font-weight: 600;
        color: rgba(255, 255, 255, 0.7) !important;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 0.75rem 1rem 0.5rem;
        margin-bottom: 0.5rem;
    }

    .nav-item {
        margin-bottom: 0.25rem;
    }

    .nav-link {
        color: rgba(255, 255, 255, 0.8) !important;
        padding: 0.75rem 1rem;
        border-radius: 0 25px 25px 0;
        margin-right: 1rem;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .nav-link::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        width: 4px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        transform: scaleY(0);
        transition: transform 0.3s ease;
    }

    .nav-link:hover {
        background: rgba(255, 255, 255, 0.1) !important;
        color: white !important;
        transform: translateX(5px);
    }

    .nav-link:hover::before {
        transform: scaleY(1);
    }

    .nav-item.active .nav-link {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.15) 0%, rgba(255, 255, 255, 0.05) 100%) !important;
        color: white !important;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .nav-item.active .nav-link::before {
        transform: scaleY(1);
    }

    .nav-link i {
        width: 20px;
        text-align: center;
        margin-right: 0.75rem;
        font-size: 1rem;
    }

    .nav-link span {
        font-weight: 500;
        font-size: 0.9rem;
    }

    .logout-section {
        padding-top: 1rem;
        border-top: 1px solid rgba(255, 255, 255, 0.15);
    }

    .logout-link {
        color: rgba(255, 255, 255, 0.8) !important;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
        border-radius: 0 25px 25px 0;
        margin-right: 1rem;
    }

    .logout-link:hover {
        background: rgba(220, 53, 69, 0.2) !important;
        color: #ff6b6b !important;
        transform: translateX(5px);
    }

    .nav-badge {
        background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
        color: white;
        font-size: 0.7rem;
        padding: 0.25rem 0.5rem;
        border-radius: 12px;
        margin-left: auto;
        font-weight: 600;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .sidebar-brand-text {
            font-size: 1rem;
        }

        .nav-link {
            padding: 0.6rem 1rem;
        }
    }
</style>

<!-- Sidebar Brand -->
<a class="d-flex align-items-center justify-content-center mt-2" href="{{ url('/') }}">
    <img src="{{ asset('images/pupr.png') }}" alt="PUPR Logo" style="width: 180px;">
</a>

<hr class="sidebar-divider my-0">

@php
    $role = Auth::user()->role->title;
    $user = Auth::user();
@endphp

@switch($role)
    @case('Pemohon')
        <!-- Dashboard -->
        <li class="nav-item {{ request()->routeIs('pemohon.dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('pemohon.dashboard') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <hr class="sidebar-divider">
        <div class="sidebar-heading">Pengaduan</div>

        <!-- Ajukan Pengaduan -->
        <li class="nav-item {{ request()->routeIs('pemohon.create') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('pemohon.create') }}">
                <i class="fas fa-fw fa-plus-circle"></i>
                <span>Ajukan Pengaduan</span>
            </a>
        </li>

        <!-- Detail Pengaduan -->
        @if ($latest = auth()->user()->reports()->latest()->first())
            <li class="nav-item {{ request()->routeIs('pemohon.detail') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('pemohon.detail', $latest->id) }}">
                    <i class="fas fa-fw fa-file-alt"></i>
                    <span>Detail Pengaduan</span>
                    @if ($latest->status == 'pending')
                        <span class="nav-badge">New</span>
                    @endif
                </a>
            </li>
        @endif

        <hr class="sidebar-divider">
        <div class="sidebar-heading">Akun</div>

        <!-- Profile -->
        <li class="nav-item {{ request()->routeIs('pemohon.profile') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('pemohon.profile') }}">
                <i class="fas fa-fw fa-user-cog"></i>
                <span>Profil Saya</span>
            </a>
        </li>
    @break

    @case('Petugas Layanan')
        <!-- Dashboard -->
        <li class="nav-item {{ request()->routeIs('petugas.dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('petugas.dashboard') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <hr class="sidebar-divider">
        <div class="sidebar-heading">Manajemen Pengaduan</div>

        <!-- Pengaduan -->
        <li class="nav-item {{ request()->routeIs('petugas.pengaduanIndex') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('petugas.pengaduan.index') }}">
                <i class="fas fa-fw fa-inbox"></i>
                <span>Pengaduan Masuk</span>
            </a>
        </li>

        <!-- Final Pengaduan -->
        <li class="nav-item {{ request()->routeIs('petugas.final') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('petugas.final.index') }}">
                <i class="fas fa-fw fa-check-double"></i>
                <span>Final Pengaduan</span>
            </a>
        </li>

        <!-- History -->
        <li class="nav-item {{ request()->routeIs('petugas.history') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('petugas.history.index') }}">
                <i class="fas fa-fw fa-history"></i>
                <span>Riwayat Pengaduan</span>
            </a>
        </li>

        <hr class="sidebar-divider">
        <div class="sidebar-heading">Manajemen Pengguna</div>

        <!-- Manage Users -->
        <li class="nav-item {{ request()->routeIs('petugas.usersIndex') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('petugas.users.index') }}">
                <i class="fas fa-fw fa-users-cog"></i>
                <span>Kelola Pengguna</span>
            </a>
        </li>

        <hr class="sidebar-divider">
        <div class="sidebar-heading">Akun</div>

        <!-- Profile -->
        <li class="nav-item {{ request()->routeIs('petugas.profile') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('petugas.profile') }}">
                <i class="fas fa-fw fa-user-cog"></i>
                <span>Profil Saya</span>
            </a>
        </li>
    @break

    @case('Bidang/Satker/SNVT')
        <!-- Dashboard -->
        <li class="nav-item {{ request()->routeIs('bidang.dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('bidang.dashboard') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <hr class="sidebar-divider">
        <div class="sidebar-heading">Analisis Teknis</div>

        <!-- Pengaduan -->
        <li class="nav-item {{ request()->routeIs('bidang.pengaduanIndex') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('bidang.pengaduan.index') }}">
                <i class="fas fa-fw fa-clipboard-check"></i>
                <span>Pengaduan Teknis</span>
            </a>
        </li>

        <!-- History -->
        <li class="nav-item {{ request()->routeIs('bidang.history') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('bidang.history.index') }}">
                <i class="fas fa-fw fa-history"></i>
                <span>Riwayat Analisis</span>
            </a>
        </li>

        <hr class="sidebar-divider">
        <div class="sidebar-heading">Akun</div>

        <!-- Profile -->
        <li class="nav-item {{ request()->routeIs('bidang.profile') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('bidang.profile') }}">
                <i class="fas fa-fw fa-user-cog"></i>
                <span>Profil Saya</span>
            </a>
        </li>
    @break

    @case('Ketua UKI')
        <!-- Dashboard -->
        <li class="nav-item {{ request()->routeIs('ketuauki.dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('ketuauki.dashboard') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <hr class="sidebar-divider">
        <div class="sidebar-heading">Koordinasi UKI</div>

        <!-- Pengaduan -->
        <li class="nav-item {{ request()->routeIs('ketuauki.pengaduanIndex') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('ketuauki.pengaduan.index') }}">
                <i class="fas fa-fw fa-tasks"></i>
                <span>Koordinasi Pengaduan</span>
            </a>
        </li>

        <!-- History -->
        <li class="nav-item {{ request()->routeIs('ketuauki.history') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('ketuauki.history.index') }}">
                <i class="fas fa-fw fa-history"></i>
                <span>Riwayat Koordinasi</span>
            </a>
        </li>

        <hr class="sidebar-divider">
        <div class="sidebar-heading">Akun</div>

        <!-- Profile -->
        <li class="nav-item {{ request()->routeIs('ketuauki.profile') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('ketuauki.profile') }}">
                <i class="fas fa-fw fa-user-cog"></i>
                <span>Profil Saya</span>
            </a>
        </li>
    @break

    @case('Kepala BBWS')
        <!-- Dashboard -->
        <li class="nav-item {{ request()->routeIs('kepalabbws.dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('kepalabbws.dashboard') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <hr class="sidebar-divider">
        <div class="sidebar-heading">Keputusan Akhir</div>

        <!-- Pengaduan -->
        <li class="nav-item {{ request()->routeIs('kepalabbws.pengaduanIndex') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('kepalabbws.pengaduan.index') }}">
                <i class="fas fa-fw fa-gavel"></i>
                <span>Keputusan Pengaduan</span>
            </a>
        </li>

        <!-- History -->
        <li class="nav-item {{ request()->routeIs('kepalabbws.history') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('kepalabbws.history.index') }}">
                <i class="fas fa-fw fa-history"></i>
                <span>Riwayat Keputusan</span>
            </a>
        </li>

        <hr class="sidebar-divider">
        <div class="sidebar-heading">Akun</div>

        <!-- Profile -->
        <li class="nav-item {{ request()->routeIs('kepalabbws.profile') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('kepalabbws.profile') }}">
                <i class="fas fa-fw fa-user-cog"></i>
                <span>Profil Saya</span>
            </a>
        </li>
    @break

@endswitch

<!-- Logout Section -->
<div class="logout-section">
    <li class="nav-item">
        <a class="logout-link nav-link" href="#"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fas fa-fw fa-sign-out-alt"></i>
            <span>Keluar</span>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </li>
</div>
