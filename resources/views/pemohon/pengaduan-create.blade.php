{{-- resources/views/pemohon/pengaduan-create.blade.php --}}
@extends('layouts.admin')

@section('title', 'Buat Pengaduan')
@section('header', 'Buat Pengaduan')

@section('admin-content')
<section id="form-pengaduan" class="p-4">
  {{-- Tampilkan error validasi --}}
  @if($errors->any())
    <div class="alert alert-danger mb-4">
      <ul class="mb-0">
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('pemohon.store') }}"
        method="POST"
        enctype="multipart/form-data">
    @csrf

    {{-- No. Registrasi --}}
    <div class="mb-3">
      <label for="number-registration" class="form-label">No. Registrasi</label>
      <input type="text"
             id="number-registration"
             name="number_registration"
             class="form-control"
             value="{{ $nextCode }}"
             readonly>
    </div>

    {{-- Rincian Pengaduan --}}
    <div class="mb-3">
      <label for="report" class="form-label">Rincian Pengaduan</label>
      <textarea name="report"
                id="report"
                class="form-control"
                rows="5"
                placeholder="Tuliskan keluhan atau masalah Anda...">{{ old('report') }}</textarea>
    </div>

    {{-- File Pendukung (minimal 1 file) --}}
    <div class="mb-3">
      <label for="documents" class="form-label">File Pendukung <span class="text-danger">*</span></label>
      <input type="file"
             name="documents[]"
             id="documents"
             class="form-control"
             multiple
             accept=".jpg,.png,.pdf">
      <small class="form-text text-muted">
        Pilih satu atau lebih file (.jpg, .png, .pdf) – masing-masing maks. 2MB
      </small>
      @error('documents')
        <div class="text-danger mt-1">{{ $message }}</div>
      @enderror
      @error('documents.*')
        <div class="text-danger mt-1">{{ $message }}</div>
      @enderror
    </div>

    {{-- Tombol aksi --}}
    <div class="d-flex justify-content-end">
      <a href="{{ route('pemohon.dashboard') }}"
         class="btn btn-outline-secondary me-2">
        Batal
      </a>
      <button type="submit" class="btn btn-primary">
        Kirim Pengaduan
      </button>
    </div>
  </form>
</section>
@endsection
