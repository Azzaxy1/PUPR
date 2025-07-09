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

        .stat-card.danger {
            border-left: 5px solid #e74a3b;
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

        .stat-icon.danger {
            background: linear-gradient(135deg, #e74a3b 0%, #c0392b 100%);
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

        .quick-actions {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        }

        .action-btn {
            display: block;
            width: 100%;
            padding: 1rem;
            margin-bottom: 1rem;
            border: 2px solid #e3e6f0;
            border-radius: 10px;
            text-decoration: none;
            color: #2c3e50;
            transition: all 0.3s ease;
        }

        .action-btn:hover {
            border-color: #4e73df;
            background: #f8f9fc;
            color: #4e73df;
            transform: translateY(-2px);
        }

        .action-btn:last-child {
            margin-bottom: 0;
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 1.5rem;
            position: relative;
            padding-left: 1rem;
        }

        .section-title::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 2px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .dashboard-header {
                padding: 1.5rem;
            }

            .dashboard-header h1 {
                font-size: 1.5rem;
            }

            .stat-value {
                font-size: 1.5rem;
            }

            .welcome-card {
                padding: 1.5rem;
            }
        }
    </style>

    <!-- Dashboard Header -->
    <div class="dashboard-header">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1>Dashboard Petugas Layanan</h1>
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
                <div class="stat-value">{{ $totalReports }}</div>
                <div class="stat-change positive">
                    <i class="fas fa-arrow-up me-1"></i>
                    Semua pengaduan yang masuk
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
                <div class="stat-change positive">
                    <i class="fas fa-arrow-up me-1"></i>
                    {{ $totalReports > 0 ? round(($totalFinished / $totalReports) * 100, 1) : 0 }}% dari total
                </div>
            </div>
        </div>

        <!-- Pengaduan Pending -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card warning">
                <div class="stat-icon warning">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-title">Pengaduan Pending</div>
                <div class="stat-value">{{ $totalReports - $totalFinished }}</div>
                <div class="stat-change {{ $totalReports - $totalFinished > 0 ? 'negative' : 'positive' }}">
                    <i class="fas fa-{{ $totalReports - $totalFinished > 0 ? 'exclamation-triangle' : 'check' }} me-1"></i>
                    {{ $totalReports - $totalFinished > 0 ? 'Memerlukan tindakan' : 'Semua selesai' }}
                </div>
            </div>
        </div>

        <!-- Total Pemohon -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card info">
                <div class="stat-icon info">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-title">Total Pemohon</div>
                <div class="stat-value">{{ $totalPemohon }}</div>
                <div class="stat-change positive">
                    <i class="fas fa-user-plus me-1"></i>
                    Pengguna terdaftar
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Row -->
    <div class="row">
        <!-- Welcome Card -->
        <div class="col-xl-6 col-lg-6 mb-4">
            <div class="welcome-card">
                <div class="welcome-content">
                    <div class="welcome-avatar">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <h3 class="mb-2">Selamat Datang!</h3>
                    <p class="text-muted mb-3">
                        Anda login sebagai <strong>{{ auth()->user()->role->title }}</strong>
                    </p>
                    <p class="text-muted mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        Gunakan menu navigasi untuk mengakses fitur-fitur sistem.
                    </p>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="col-xl-6 col-lg-6 mb-4">
            <div class="quick-actions">
                <h5 class="section-title">Menu Utama</h5>

                <a href="{{ route('petugas.pengaduan.index') }}" class="action-btn">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon primary me-3" style="width: 40px; height: 40px; margin-bottom: 0;">
                            <i class="fas fa-inbox"></i>
                        </div>
                        <div>
                            <strong>Pengaduan Masuk</strong>
                            <br>
                            <small class="text-muted">Kelola pengaduan baru dari masyarakat</small>
                        </div>
                    </div>
                </a>

                <a href="{{ route('petugas.final.index') }}" class="action-btn">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon success me-3" style="width: 40px; height: 40px; margin-bottom: 0;">
                            <i class="fas fa-check-double"></i>
                        </div>
                        <div>
                            <strong>Final Pengaduan</strong>
                            <br>
                            <small class="text-muted">Tindak lanjuti dan selesaikan pengaduan</small>
                        </div>
                    </div>
                </a>

                <a href="{{ route('petugas.users.index') }}" class="action-btn">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon info me-3" style="width: 40px; height: 40px; margin-bottom: 0;">
                            <i class="fas fa-users-cog"></i>
                        </div>
                        <div>
                            <strong>Kelola Pengguna</strong>
                            <br>
                            <small class="text-muted">Manajemen pengguna dan hak akses</small>
                        </div>
                    </div>
                </a>

                <a href="{{ route('petugas.history.index') }}" class="action-btn">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon warning me-3" style="width: 40px; height: 40px; margin-bottom: 0;">
                            <i class="fas fa-history"></i>
                        </div>
                        <div>
                            <strong>Riwayat Pengaduan</strong>
                            <br>
                            <small class="text-muted">Lihat histori pengaduan yang telah diproses</small>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection
