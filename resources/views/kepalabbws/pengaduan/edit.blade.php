@extends('layouts.admin')

@section('admin-content')
@php
  $lastTx = $report->transactions->last();
  $lastStatus = optional($lastTx->status)->title;
@endphp

<div class="container-fluid py-4">
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-light">
          <h5 class="mb-0">Detail Pengaduan #{{ $report->number_registration }}</h5>
        </div>
        <div class="card-body">
          <dl class="row">
            <dt class="col-sm-3">Pelapor</dt>
            <dd class="col-sm-9">{{ optional($report->user)->name ?? '-' }}</dd>

            <dt class="col-sm-3">Tanggal Masuk</dt>
            <dd class="col-sm-9">{{ $report->created_at->format('d/m/Y H:i') }}</dd>

            <dt class="col-sm-3">Isi Laporan</dt>
            <dd class="col-sm-9">{{ $report->report }}</dd>

            <dt class="col-sm-3">Status Terakhir</dt>
            <dd class="col-sm-9">
              <span class="badge {{
                $lastStatus=='Diproses oleh Kepala BBWS'? 'bg-primary':(
                $lastStatus=='Selesai'? 'bg-success':'bg-secondary'
              )}}">{{ $lastStatus ?? '-' }}</span>
            </dd>
          </dl>
        </div>
      </div>

      <div class="card shadow-sm border-0">
        <div class="card-header bg-light">
          <h5 class="mb-0">Upload Jawaban & Finalisasi</h5>
        </div>
        <div class="card-body">
          @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
          @endif
          @if($errors->any())
            <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
          @endif
          <form action="{{ route('kepalabbws.pengaduan.update', $report->id) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="mb-3">
              <label class="form-label">Catatan (opsional)</label>
              <textarea name="notes" class="form-control" rows="3">{{ old('notes') }}</textarea>
            </div>
            <div class="mb-3">
              <label class="form-label">Upload File Jawaban</label>
              <input type="file" name="file" class="form-control" required>
              <small class="text-muted">(.pdf/.jpg/.png — max 4MB)</small>
            </div>
            <div class="d-flex justify-content-end">
              <a href="{{ route('kepalabbws.pengaduan.index') }}" class="btn btn-outline-secondary me-2">Batal</a>
              <button type="submit" class="btn btn-success">Finalisasi</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
