@extends('layouts.admin')

@section('admin-content')
<div class="container-fluid py-4">
  <div class="card shadow-sm border-0">
    <div class="card-header bg-light d-flex justify-content-between align-items-center">
      <h5 class="mb-0">Riwayat Disposisi Saya</h5>
      <form class="d-flex" method="GET" action="{{ route('ketuauki.history.index') }}">
        <input type="text" name="search" class="form-control form-control-sm me-2" placeholder="Cari registrasi..." value="{{ request('search') }}">
        <button type="submit" class="btn btn-sm btn-outline-primary">Cari</button>
      </form>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover mb-0">
          <thead class="table-light">
            <tr>
              <th>#</th>
              <th>No. Registrasi</th>
              <th>Pelapor</th>
              <th>Aksi</th>
              <th>Status</th>
              <th>Tanggal Disposisi</th>
              <th>Catatan</th>
            </tr>
          </thead>
          <tbody>
            @foreach($transactions as $i => $tx)
            <tr>
              <td>{{ $transactions->firstItem() + $i }}</td>
              <td>{{ $tx->report->number_registration }}</td>
              <td>{{ optional($tx->report->user)->name ?? '-' }}</td>
              <td>{{ $tx->status_ref == 3 ? 'Disposisi' : '-' }}</td>
              <td>
                @php
                  $statusTitle = optional($tx->status)->title;
                  $badge = match($statusTitle) {
                    'Diproses' => 'bg-info',
                    'Ditolak'  => 'bg-danger',
                    'Selesai'  => 'bg-success',
                    default    => 'bg-secondary',
                  };
                @endphp
                <span class="badge {{ $badge }}">{{ $statusTitle ?? '-' }}</span>
              </td>
              <td>{{ optional($tx->approve_dates)->format('d/m/Y H:i') }}</td>
              <td>{{ $tx->notes ?? '-' }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    <div class="card-footer bg-white">
      {{ $transactions->withQueryString()->links() }}
    </div>
  </div>
</div>
@endsection
