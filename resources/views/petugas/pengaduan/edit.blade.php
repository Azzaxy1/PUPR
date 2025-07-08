@extends('layouts.admin')

@section('admin-content')
@php
  $lastTx = $report->transactions->last();
  $statusLast = optional($lastTx->status)->title;
@endphp
<div class="container-fluid py-4">
  <div class="row g-4">
    <div class="col-lg-8">
      <div class="card shadow-sm border-0">
        <div class="card-header bg-light">
          <h5 class="mb-0">Detail Pengaduan</h5>
        </div>
        <div class="card-body">
          <dl class="row">
            <dt class="col-sm-3">No. Registrasi</dt>
            <dd class="col-sm-9">{{ $report->number_registration }}</dd>

            <dt class="col-sm-3">Pemohon</dt>
            <dd class="col-sm-9">{{ $report->user->name }} ({{ $report->user->email }})</dd>

            <dt class="col-sm-3">Isi Laporan</dt>
            <dd class="col-sm-9">{{ $report->report }}</dd>

            <dt class="col-sm-3">Status Terakhir</dt>
            <dd class="col-sm-9">
            @php
                $lastStatus = optional($lastTx->status)->title;
                $badgeClass = match($lastStatus) {
                'Menunggu Verifikasi' => 'bg-warning',
                'Diproses'            => 'bg-info',
                'Ditolak'             => 'bg-danger',
                'Selesai'             => 'bg-success',
                default               => 'bg-secondary',
                };
            @endphp
            <span class="badge {{ $badgeClass }}">
                {{ $lastStatus ?? '—' }}
            </span>
            </dd>

            <dt class="col-sm-3">Tanggal Dibuat</dt>
            <dd class="col-sm-9">{{ $report->created_at->format('d/m/Y H:i') }}</dd>
          </dl>
        </div>
      </div>

      <div class="card shadow-sm border-0">
        <div class="card-header bg-light">
          <h5 class="mb-0">Riwayat Status</h5>
        </div>
        <div class="card-body">
          <ul class="timeline">
            @foreach($report->transactions as $tx)
            <li class="mb-4">
              <div><small class="text-muted">{{ optional($tx->approve_dates)->format('d/m/Y H:i') }}</small></div>
              <strong>{{ optional($tx->status)->title }}</strong>
              @if($tx->notes)<p>{{ $tx->notes }}</p>@endif
            </li>
            @endforeach
          </ul>
        </div>
      </div>
    </div>

    <div class="col-lg-4">
      <div class="card shadow-sm border-0">
        <div class="card-header bg-light">
          <h5 class="mb-0">Tindakan Verifikasi</h5>
        </div>
        <div class="card-body">
          <form action="{{ route('petugas.pengaduan.update',$report->id) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-3">
              <label class="form-label">Pilih Aksi</label>
              <select name="action" class="form-select" required>
                <option value="approve">Setujui (Diproses)</option>
                <option value="reject">Tolak</option>
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label">Catatan (opsional)</label>
              <textarea name="notes" class="form-control" rows="3">{{ old('notes') }}</textarea>
            </div>
            <div class="d-grid gap-2">
              <button type="submit" class="btn btn-success">Simpan & Proses</button>
              <a href="{{ route('petugas.pengaduan.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
