@extends('layouts.admin')

@section('admin-content')
@php
  $lastTx = $report->transactions->last();
  $lastStatus = optional($lastTx->status)->title;
@endphp

<div class="container-fluid py-4">
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="card shadow-sm border-0">
        <div class="card-header bg-light">
          <h5 class="mb-0">Detail Pengaduan #{{ $report->number_registration }}</h5>
        </div>
        <div class="card-body">
          <dl class="row">
            <dt class="col-sm-3">Pemohon</dt>
            <dd class="col-sm-9">{{ optional($report->user)->name ?? '-' }}</dd>

            <dt class="col-sm-3">Tanggal</dt>
            <dd class="col-sm-9">{{ $report->created_at->format('d/m/Y H:i') }}</dd>

            <dt class="col-sm-3">Isi Laporan</dt>
            <dd class="col-sm-9">{{ $report->report }}</dd>

            <dt class="col-sm-3">Status Terakhir</dt>
            <dd class="col-sm-9">
              <span class="badge {{
                $lastStatus=='Menunggu Verifikasi'? 'bg-warning': (
                $lastStatus=='Diproses'? 'bg-info': (
                $lastStatus=='Ditolak'? 'bg-danger': (
                $lastStatus=='Selesai'? 'bg-success': 'bg-secondary'
              ))) }}">
                {{ $lastStatus ?? '-' }}
              </span>
            </dd>
          </dl>
        </div>
      </div>

      <div class="card shadow-sm border-0 mt-4">
        <div class="card-header bg-light">
          <h5 class="mb-0">Disposisi Tindakan</h5>
        </div>
        <div class="card-body">
          <form action="{{ route('ketuauki.pengaduan.update', $report->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
              <label class="form-label">Tindakan</label>
              <select name="action" class="form-select" required>
                <option value="approve">Setujui (Proses)</option>
                <option value="reject">Tolak</option>
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label">Catatan (opsional)</label>
              <textarea name="notes" class="form-control" rows="3">{{ old('notes') }}</textarea>
            </div>
            <div class="d-flex justify-content-end">
              <a href="{{ route('ketuauki.pengaduan.index') }}" class="btn btn-outline-secondary me-2">Batal</a>
              <button type="submit" class="btn btn-success">Kirim Disposisi</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
