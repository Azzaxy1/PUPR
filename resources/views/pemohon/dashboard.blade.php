@extends('layouts.admin')

@section('admin-content')

<div class="row">

  <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-primary shadow h-100 py-2">
          <div class="card-body">
              <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                          Pengaduan Selesai</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalFinished }}</div>
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
                          Total Pengaduan</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalAll }}</div>
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
                          Belum Selesai</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalAll - $totalFinished }}</div>
                  </div>
                  <div class="col-auto">
                      <i class="fas fa-calendar fa-2x text-gray-300"></i>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-success shadow h-100 py-2">
          <div class="card-body">
              <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                      <div class="h5 mb-0 font-weight-bold text-gray-800">Selamat Datang {{ auth()->user()->name }}</div>
                  </div>
              </div>
          </div>
      </div>
  </div>

</div>

<div class="card shadow mb-4">
  <div class="card-header py-3">
    <a href="{{ route('pemohon.create') }}" class="btn btn-primary">
        Buat Pengaduan Baru.
    </a>
  </div>
  <div class="card-body">
    <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                  <th>No</th>
                  <th>Kode</th>
                  <th>Isi</th>
                  <th>Status Terakhir</th>
                  <th>Tanggal Dibuat</th>
                  <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                  <th>No</th>
                  <th>Kode</th>
                  <th>Isi</th>
                  <th>Status Terakhir</th>
                  <th>Tanggal Dibuat</th>
                  <th class="text-center">Aksi</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach($reports as $report)
                  <tr>
                    <td>{{ $loop->iteration + ($reports->currentPage() - 1) * $reports->perPage() }}</td>
                    <td>{{ $report->number_registration }}</td>
                    <td>{{ Str::limit($report->report, 50) }}</td>
                    <td>{{ $report->transactions->last()->status->title }}</td>
                    <td>{{ $report->created_at->format('d/m/Y') }}</td>
                    <td class="align-middle text-center">
                      <a href="{{ route('pemohon.detail', $report->id) }}"
                        class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-eye"></i>
                      </a>
                    </td>
                  </tr>
                @endforeach
            </tbody>
        </table>
    </div>
  </div>
</div>
@endsection
