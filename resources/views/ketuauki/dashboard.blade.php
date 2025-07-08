@extends('layouts.admin')

@section('admin-content')

<div class="row">

  <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-primary shadow h-100 py-2">
          <div class="card-body">
              <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                          Total Disposisi</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalApproved }}</div>
                  </div>
                  <div class="col-auto">
                      <i class="fas fa-calendar fa-2x text-gray-300"></i>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-primary shadow h-100 py-2">
          <div class="card-body">
              <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                          Pending Disposisi</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalPending }}</div>
                  </div>
                  <div class="col-auto">
                      <i class="fas fa-calendar fa-2x text-gray-300"></i>
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>
<div class="card shadow-sm border-0 mt-4">
    <div class="card-header bg-light">
      <h5 class="mb-0">Pengaduan Menunggu Disposisi</h5>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover mb-0">
          <thead class="table-light">
            <tr>
              <th>#</th>
              <th>No. Registrasi</th>
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
                <a href="{{ route('ketuauki.pengaduan.edit', $report->id) }}" class="btn btn-sm btn-primary">
                  <i class="fas fa-edit me-1"></i> Disposisi
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
