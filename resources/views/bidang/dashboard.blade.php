@extends('layouts.admin')

@section('admin-content')
<div class="container-fluid py-4">
  <div class="row g-4">
    <!-- Card: Total Telaah -->
    <div class="col-md-6 col-lg-4">
      <div class="card shadow-sm border-0 h-100">
        <div class="card-body d-flex align-items-center">
          <div class="me-3">
            <i class="fas fa-check-circle fa-2x text-success"></i>
          </div>
          <div>
            <h6 class="text-muted mb-1">Total Telaah</h6>
            <h3 class="mb-0">{{ $totalApproved }}</h3>
          </div>
        </div>
      </div>
    </div>
    <!-- Card: Pending Telaah -->
    <div class="col-md-6 col-lg-4">
      <div class="card shadow-sm border-0 h-100">
        <div class="card-body d-flex align-items-center">
          <div class="me-3">
            <i class="fas fa-hourglass-half fa-2x text-warning"></i>
          </div>
          <div>
            <h6 class="text-muted mb-1">Pending Telaah</h6>
            <h3 class="mb-0">{{ $totalPending }}</h3>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Table: Pengaduan Menunggu Telaah -->
  <div class="card shadow-sm border-0 mt-4">
    <div class="card-header bg-light">
      <h5 class="mb-0">Pengaduan Menunggu Telaah</h5>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover mb-0">
          <thead class="table-light">
            <tr>
              <th>#</th>
              <th>No. Reg.</th>
              <th>Pelapor</th>
              <th>Isi Laporan</th>
              <th>Tanggal Masuk</th>
              <th class="text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach($reports as $i => $report)
            <tr>
              <td>{{ $reports->firstItem() + $i }}</td>
              <td>{{ $report->number_registration }}</td>
              <td>{{ optional($report->user)->name ?? '-' }}</td>
              <td>{{ Str::limit($report->report, 60) }}</td>
              <td>{{ $report->created_at->format('d/m/Y H:i') }}</td>
              <td class="text-center">
                <a href="{{ route('bidang.pengaduan.edit', $report->id) }}" class="btn btn-sm btn-primary">
                  <i class="fas fa-edit me-1"></i> Telaah
                </a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    <div class="card-footer bg-white">
      {{ $reports->links() }}
    </div>
  </div>
</div>
@endsection
