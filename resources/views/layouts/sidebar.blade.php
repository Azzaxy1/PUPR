{{-- resources/views/layouts/sidebar.blade.php --}}
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/') }}">
    <div class="sidebar-brand-icon rotate-n-15">
        <i class="fas fa-laugh-wink"></i>
    </div>
    <div class="sidebar-brand-text mx-3">PUPR PANEL
      <div class="sidebar-heading text-white small">
          {{ Auth::user()->name }}
      </div>
    </div>
</a>

<hr class="sidebar-divider my-0">
@php $role = Auth::user()->role->title; @endphp
@switch($role)
    @case('Pemohon')
        <li class="nav-item {{ request()->routeIs('pemohon.dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('pemohon.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
        </li>
        <hr class="sidebar-divider">
        <div class="sidebar-heading text-white small">Fitur</div>
        <li class="nav-item {{ request()->routeIs('pemohon.create') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('pemohon.create') }}">
            <i class="fas fa-fw fa-envelope"></i>
            <span>Ajukan Pengaduan</span>
        </a>
        </li>
        @if($latest = auth()->user()->reports()->latest()->first())
        <li class="nav-item {{ request()->routeIs('pemohon.detail') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('pemohon.detail', $latest->id) }}">
            <i class="fas fa-fw fa-folder"></i>
            <span>Detail Pengaduan</span>
            </a>
        </li>
        @endif
        <div class="sidebar-heading text-white small">Personal</div>
        <li class="nav-item {{ request()->routeIs('pemohon.profile') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('pemohon.profile') }}">
            <i class="fas fa-fw fa-user"></i>
            <span>Profile</span>
        </a>
        </li>
    @break
    @case('Petugas Layanan')
        <li class="nav-item {{ request()->routeIs('petugas.dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('petugas.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
        </li>
        <li class="nav-item {{ request()->routeIs('petugas.pengaduanIndex') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('petugas.pengaduan.index') }}">
            <i class="fas fa-fw fa-list"></i>
            <span>Pengaduan</span>
        </a>
        </li>
        <li class="nav-item {{ request()->routeIs('petugas.final') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('petugas.final.index') }}">
            <i class="fas fa-fw fa-check-circle"></i>
            <span>Final Pengaduan</span>
        </a>
        </li>
        <li class="nav-item {{ request()->routeIs('petugas.history') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('petugas.history.index') }}">
            <i class="fas fa-fw fa-history"></i>
            <span>History Pengaduan</span>
        </a>
        </li>
        <li class="nav-item {{ request()->routeIs('petugas.usersIndex') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('petugas.users.index') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>Manage Pengguna</span>
        </a>
        </li>
        <li class="nav-item {{ request()->routeIs('petugas.profile') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('petugas.profile') }}">
            <i class="fas fa-fw fa-user"></i>
            <span>Profile</span>
        </a>
        </li>
    @break
    @case('Bidang/Satker/SNVT')
        <li class="nav-item {{ request()->routeIs('bidang.dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('bidang.dashboard') }}">
            <i class="fas fa-fw fa-list"></i>
            <span>Dashboard</span>
        </a>
        <li class="nav-item {{ request()->routeIs('bidang.pengaduanIndex') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('bidang.pengaduan.index') }}">
            <i class="fas fa-fw fa-list"></i>
            <span>Pengaduan</span>
        </a>
        </li>
        <li class="nav-item {{ request()->routeIs('bidang.history') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('bidang.history.index') }}">
            <i class="fas fa-fw fa-history"></i>
            <span>History Pengaduan</span>
        </a>
        </li>
        <li class="nav-item {{ request()->routeIs('bidang.profile') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('bidang.profile') }}">
            <i class="fas fa-fw fa-user"></i>
            <span>Profile</span>
        </a>
        </li>
    @break
    @case('Ketua UKI')
        <li class="nav-item {{ request()->routeIs('ketuauki.pengaduanIndex') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('ketuauki.dashboard') }}">
            <i class="fas fa-fw fa-list"></i>
            <span>Dashboard</span>
        </a>
        </li>
        <li class="nav-item {{ request()->routeIs('ketuauki.pengaduanIndex') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('ketuauki.pengaduan.index') }}">
            <i class="fas fa-fw fa-list"></i>
            <span>Pengaduan</span>
        </a>
        </li>
        <li class="nav-item {{ request()->routeIs('ketuauki.history') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('ketuauki.history.index') }}">
            <i class="fas fa-fw fa-history"></i>
            <span>History Pengaduan</span>
        </a>
        </li>
        <li class="nav-item {{ request()->routeIs('ketuauki.profile') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('ketuauki.profile') }}">
            <i class="fas fa-fw fa-user"></i>
            <span>Profile</span>
        </a>
        </li>
    @break
    @case('Kepala BBWS')
        <li class="nav-item {{ request()->routeIs('kepalabbws.dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('kepalabbws.dashboard') }}">
            <i class="fas fa-fw fa-list"></i>
            <span>Dashboard</span>
        </a>
        </li>
        <li class="nav-item {{ request()->routeIs('kepalabbws.pengaduanIndex') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('kepalabbws.pengaduan.index') }}">
            <i class="fas fa-fw fa-list"></i>
            <span>Pengaduan</span>
        </a>
        </li>
        <li class="nav-item {{ request()->routeIs('kepalabbws.history') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('kepalabbws.history.index') }}">
            <i class="fas fa-fw fa-history"></i>
            <span>History Pengaduan</span>
        </a>
        </li>
        <li class="nav-item {{ request()->routeIs('kepalabbws.profile') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('kepalabbws.profile') }}">
            <i class="fas fa-fw fa-user"></i>
            <span>Profile</span>
        </a>
        </li>
    @break
@endswitch

<hr class="sidebar-divider">
<li class="nav-item">
  <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
    <i class="fas fa-fw fa-sign-out-alt"></i>
    <span>Logout</span>
  </a>
  <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
  </form>
</li>


