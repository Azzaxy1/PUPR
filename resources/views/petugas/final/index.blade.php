@extends('layouts.admin')

@section('admin-content')
    <div class="container-fluid py-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Pengaduan Selesai</h5>
                <form class="d-flex" method="GET" action="{{ route('petugas.final.index') }}">
                    <input type="text" name="search" class="form-control form-control-sm me-2"
                        placeholder="Cari registrasi..." value="{{ request('search') }}">
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
                                <th>Tanggal Selesai</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($finalReports as $i => $report)
                                <tr>
                                    <td>{{ $finalReports->firstItem() + $i }}</td>
                                    <td>{{ $report->number_registration }}</td>
                                    <td>{{ optional($report->user)->name ?? '-' }}</td>
                                    <td>{{ optional($report->transactions->where('status_active', 1)->last()->approve_dates)->format('d/m/Y H:i') ?? '-' }}
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('petugas.final.pdf', $report->id) }}"
                                            class="btn btn-sm btn-outline-danger me-1">
                                            <i class="fas fa-file-pdf"></i> PDF
                                        </a>
                                        <a href="{{ route('petugas.pengaduan.edit', $report->id) }}"
                                            class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white">
                {{ $finalReports->withQueryString()->links() }}
            </div>
        </div>
    </div>
@endsection
