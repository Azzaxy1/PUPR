@extends('layouts.admin')

@section('admin-content')
<div class="container-fluid py-4">
  <div class="row g-4">
    <!-- Card: Total Aktif -->
    <div class="col-md-6 col-lg-3">
      <div class="card shadow-sm border-0 h-100">
        <div class="card-body d-flex align-items-center">
          <div class="me-3">
            <i class="fas fa-tasks fa-2x text-primary"></i>
          </div>
          <div>
            <h6 class="text-muted mb-1">Pengaduan Aktif</h6>
            <h3 class="mb-0">{{ $totalActive }}</h3>
          </div>
        </div>
      </div>
    </div>
    <!-- Card: Selesai -->
    <div class="col-md-6 col-lg-3">
      <div class="card shadow-sm border-0 h-100">
        <div class="card-body d-flex align-items-center">
          <div class="me-3">
            <i class="fas fa-check-circle fa-2x text-success"></i>
          </div>
          <div>
            <h6 class="text-muted mb-1">Pengaduan Selesai</h6>
            <h3 class="mb-0">{{ $totalFinished }}</h3>
          </div>
        </div>
      </div>
    </div>
    <!-- Card: Pemohon -->
    <div class="col-md-6 col-lg-3">
      <div class="card shadow-sm border-0 h-100">
        <div class="card-body d-flex align-items-center">
          <div class="me-3">
            <i class="fas fa-users fa-2x text-info"></i>
          </div>
          <div>
            <h6 class="text-muted mb-1">Total Pemohon</h6>
            <h3 class="mb-0">{{ $totalPemohon }}</h3>
          </div>
        </div>
      </div>
    </div>
    <!-- Card: Pending -->
    <div class="col-md-6 col-lg-3">
      <div class="card shadow-sm border-0 h-100">
        <div class="card-body d-flex align-items-center">
          <div class="me-3">
            <i class="fas fa-hourglass-half fa-2x text-warning"></i>
          </div>
          <div>
            <h6 class="text-muted mb-1">Pending</h6>
            <h3 class="mb-0">{{ $pending }}</h3>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
