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

        .stat-change {
            font-size: 0.85rem;
            font-weight: 500;
        }

        .stat-change.positive {
            color: #1cc88a;
        }

        .stat-change.negative {
            color: #e74a3b;
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
                <h1>Dashboard Ketua UKI</h1>
                <p>Selamat datang kembali, {{ auth()->user()->name }}!</p>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row">
        <!-- Total Disposisi -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card success">
                <div class="stat-icon success">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-title">Total Disposisi</div>
                <div class="stat-value">{{ $totalApproved }}</div>
                <div class="stat-change positive">
                    <i class="fas fa-arrow-up me-1"></i>
                    Disposisi yang sudah disetujui
                </div>
            </div>
        </div>

        <!-- Pending Disposisi -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card warning">
                <div class="stat-icon warning">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-title">Pending Disposisi</div>
                <div class="stat-value">{{ $totalPending }}</div>
                <div class="stat-change {{ $totalPending > 0 ? 'negative' : 'positive' }}">
                    <i class="fas fa-{{ $totalPending > 0 ? 'exclamation-triangle' : 'check' }} me-1"></i>
                    {{ $totalPending > 0 ? 'Menunggu disposisi' : 'Semua terdisposisi' }}
                </div>
            </div>
        </div>

        <!-- Total Pengaduan -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card primary">
                <div class="stat-icon primary">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div class="stat-title">Total Pengaduan</div>
                <div class="stat-value">{{ $totalApproved + $totalPending }}</div>
                <div class="stat-change positive">
                    <i class="fas fa-arrow-up me-1"></i>
                    Semua pengaduan masuk
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
                    <p class="text-muted mb-0">
                        <i class="fas fa-user-tie me-1"></i>
                        {{ auth()->user()->role->title }}
                    </p>
                    <p class="text-muted mb-0">
                        <i class="fas fa-calendar-alt me-1"></i>
                        {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0 mt-4">
        <div class="card-header bg-light">
            <h5 class="mb-0">Pengaduan Menunggu Disposisi</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>No. Registrasi</th>
                            <th>Pelapor</th>
                            <th>Isi Laporan</th>
                            <th>Tanggal Masuk</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reports as $i => $report)
                            <tr>
                                <td>{{ $reports->firstItem() + $i }}</td>
                                <td>{{ $report->number_registration }}</td>
                                <td>{{ optional($report->user)->name ?? '-' }}</td>
                                <td>{{ Str::limit($report->report, 60) }}</td>
                                <td>{{ $report->created_at->format('d/m/Y H:i') }}</td>
                                <td class="text-center">
                                    <a href="{{ route('ketuauki.pengaduan.edit', $report->id) }}"
                                        class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit me-1"></i> Disposisi
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white">
            {{ $reports->links() }}
        </div>
    </div>
    </div>
@endsection
