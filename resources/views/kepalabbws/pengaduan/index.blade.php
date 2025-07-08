@extends('layouts.admin')

@section('admin-content')
<div class="container-fluid py-4">
  <div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-light d-flex justify-content-between align-items-center">
      <h5 class="mb-0">Pengaduan Siap Finalisasi</h5>
      <a href="{{ route('kepalabbws.pengaduan.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="fas fa-sync-alt me-1"></i> Refresh
      </a>
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
              <th>Status Terakhir</th>
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
              <td>
                @php
                  $lastStatus = optional($report->transactions->last()?->status)->title;
                  $badgeClass = match($lastStatus) {
                    'Diproses' => 'bg-info',
                    'Diproses oleh Kepala BBWS' => 'bg-primary',
                    'Selesai'  => 'bg-success',
                    default    => 'bg-secondary',
                  };
                @endphp
                <span class="badge {{ $badgeClass }}">{{ $lastStatus ?? '-' }}</span>
              </td>
              <td>{{ $report->created_at->format('d/m/Y H:i') }}</td>
              <td class="text-center">
                <a href="{{ route('kepalabbws.pengaduan.edit', $report->id) }}" class="btn btn-sm btn-primary">
                  <i class="fas fa-file-upload me-1"></i> Finalisasi
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
