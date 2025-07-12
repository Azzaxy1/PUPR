@extends('layouts.admin')

@section('admin-content')
    <div class="container-fluid py-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Riwayat Transaksi yang Disetujui Petugas Layanan</h5>
                <form class="d-flex" method="GET" action="{{ route('petugas.history.index') }}">
                    <input type="text" name="search" class="form-control form-control-sm me-2" placeholder="Cari..."
                        value="{{ request('search') }}">
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
                                <th>Status</th>
                                <th>Petugas Layanan</th>
                                <th>Tanggal Approve</th>
                                <th>Catatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transactions as $i => $tx)
                                <tr>
                                    <td>{{ $transactions->firstItem() + $i }}</td>
                                    <td>{{ $tx->report->number_registration }}</td>
                                    <td>{{ optional($tx->report->user)->name ?? '-' }}</td>
                                    <td>
                                        <span
                                            class="badge
                    @switch(optional($tx->status)->title)
                      @case('Menunggu Verifikasi') bg-warning @break
                      @case('Diproses')            bg-info    @break
                      @case('Ditolak')             bg-danger  @break
                      @case('Selesai')             bg-success @break
                      @default                    bg-secondary
                    @endswitch
                  ">
                                            {{ optional($tx->status)->title ?? '-' }}
                                        </span>
                                    </td>
                                    <td>{{ optional($tx->officer)->name ?? '-' }}</td>
                                    <td>{{ $tx->approve_dates }}</td>
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
