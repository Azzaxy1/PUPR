{{-- resources/views/pemohon/pengaduan-detail.blade.php --}}
@extends('layouts.admin')

@section('title','Detail Pengaduan')
@section('header','Detail Pengaduan')

@section('admin-content')
<div class="container mt-4">
    <h2>Detail Pengaduan {{ $report->number_registration }}</h2>

    {{-- Isi laporan --}}
    <div class="mb-3">
        <label class="form-label"><strong>Isi Pengaduan:</strong></label>
        <p>{{ $report->report }}</p>
    </div>

    {{-- Riwayat status --}}
    <div class="mb-3">
        <label class="form-label"><strong>Riwayat Status:</strong></label>
        <ul class="list-group">
            @foreach($report->transactions as $tx)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    {{ $tx->status->title }}
                </li>
            @endforeach
        </ul>
    </div>

    {{-- Dokumen pendukung --}}
    <div class="mb-3">
        <label class="form-label"><strong>Dokumen Pendukung:</strong></label>
        @if($report->documents->isEmpty())
            <p><em>Tidak ada dokumen.</em></p>
        @else
            <ul class="list-group">
                @foreach($report->documents as $doc)
                    @php
                        // ambil ekstensi file
                        $ext = pathinfo($doc->filename, PATHINFO_EXTENSION);
                        // buat nama custom
                        $customName = 'dokumen_pendukung'.$report->number_registration.'.'.$ext;
                        // pastikan menggunakan public/storage (setelah php artisan storage:link)
                        $url = asset('storage/'.$doc->filename);
                    @endphp
                    <li class="list-group-item">
                        <a 
                          href="{{ $url }}" 
                          target="_blank" 
                          download="{{ $customName }}"
                        >
                            {{ $customName }}
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

    {{-- Dokumen output (jika ada) --}}
    @if($report->documentOutputs->isNotEmpty())
    <div class="mb-3">
        <label class="form-label"><strong>Dokumen Output:</strong></label>
        <ul class="list-group">
            @foreach($report->documentOutputs as $out)
                @php
                    $filename  = basename($doc->filename);
                    $ext       = pathinfo($filename, PATHINFO_EXTENSION);
                    $customName = 'dokumen_pendukung' . $report->number_registration . '.' . $ext;
                @endphp
                <li class="list-group-item">
                    <a href="{{ route('pemohon.dokumen.pendukung', ['filename' => $filename]) }}"
                    target="_blank">
                        {{ $customName }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- Tombol Download PDF jika selesai --}}
    @if($report->transactions->last()->m_status_tab_id == 4)
    <div class="mt-4">
        <a href="{{ route('pemohon.downloadPdf', $report->id) }}" class="btn btn-secondary">
            <i class="fas fa-file-pdf"></i> Download PDF
        </a>
    </div>
    @endif

    <div class="mt-3">
        <a href="{{ route('pemohon.dashboard') }}" class="btn btn-light">Kembali ke Dashboard</a>
    </div>
</div>
@endsection
