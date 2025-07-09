@extends('layouts.admin')

@section('admin-content')
    <style>
        /* Custom Dashboard Styling */
        .dashboard-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem;
            border-radius: 15px;
            margin-bottom: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .dashboard-header h1 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .dashboard-header p {
            font-size: 1.1rem;
            opacity: 0.9;
            margin-bottom: 0;
        }

        .dashboard-time {
            font-size: 0.9rem;
            opacity: 0.8;
        }

        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            border: none;
            transition: all 0.3s ease;
            height: 100%;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .stat-card.primary {
            border-left: 5px solid #4e73df;
        }

        .stat-card.success {
            border-left: 5px solid #1cc88a;
        }

        .stat-card.warning {
            border-left: 5px solid #f6c23e;
        }

        .stat-card.info {
            border-left: 5px solid #36b9cc;
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .stat-icon.primary {
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
            color: white;
        }

        .stat-icon.success {
            background: linear-gradient(135deg, #1cc88a 0%, #17a673 100%);
            color: white;
        }

        .stat-icon.warning {
            background: linear-gradient(135deg, #f6c23e 0%, #dda20a 100%);
            color: white;
        }

        .stat-icon.info {
            background: linear-gradient(135deg, #36b9cc 0%, #2c9faf 100%);
            color: white;
        }

        .stat-title {
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            color: #5a5c69;
            margin-bottom: 0.5rem;
            letter-spacing: 0.5px;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 0.5rem;
        }

        .stat-description {
            font-size: 0.85rem;
            color: #6c757d;
            font-weight: 500;
        }

        .welcome-card {
            background: linear-gradient(135deg, #f8f9fc 0%, #e9ecef 100%);
            border-radius: 15px;
            padding: 2rem;
            border: 2px solid #e3e6f0;
            position: relative;
            overflow: hidden;
        }

        .welcome-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(102, 126, 234, 0.1) 0%, transparent 70%);
            animation: pulse 4s ease-in-out infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
                opacity: 0.5;
            }

            50% {
                transform: scale(1.1);
                opacity: 0.8;
            }
        }

        .welcome-content {
            position: relative;
            z-index: 2;
        }

        .welcome-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: white;
            margin-bottom: 1rem;
            font-weight: 700;
        }
    </style>


    <!-- Dashboard Header -->
    <div class="dashboard-header">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1>Dashboard Pemohon</h1>
                <p>Selamat datang kembali, {{ auth()->user()->name }}!</p>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row">
        <!-- Total Pengaduan -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card primary">
                <div class="stat-icon primary">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div class="stat-title">Total Pengaduan</div>
                <div class="stat-value">{{ $totalAll }}</div>
                <div class="stat-description">
                    Semua pengaduan yang Anda buat
                </div>
            </div>
        </div>

        <!-- Pengaduan Selesai -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card success">
                <div class="stat-icon success">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-title">Pengaduan Selesai</div>
                <div class="stat-value">{{ $totalFinished }}</div>
                <div class="stat-description">
                    Pengaduan yang sudah diselesaikan
                </div>
            </div>
        </div>

        <!-- Belum Selesai -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card warning">
                <div class="stat-icon warning">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-title">Belum Selesai</div>
                <div class="stat-value">{{ $totalAll - $totalFinished }}</div>
                <div class="stat-description">
                    Pengaduan dalam proses
                </div>
            </div>
        </div>

        <!-- Welcome Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="welcome-card">
                <div class="welcome-content">
                    <div class="welcome-avatar">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <h5 class="mb-1">{{ auth()->user()->name }}</h5>
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
                        @foreach ($reports as $report)
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
