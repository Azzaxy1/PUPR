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
            position: relative;
            overflow: hidden;
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

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            transform: translate(30px, -30px);
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
            position: relative;
            z-index: 2;
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

        .info-panel {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            margin-top: 2rem;
        }

        .info-item {
            display: flex;
            align-items: center;
            padding: 1rem;
            margin-bottom: 1rem;
            border-left: 4px solid transparent;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .info-item:hover {
            background: #f8f9fc;
            border-left-color: #4e73df;
        }

        .info-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            font-size: 1rem;
        }

        .info-icon.primary {
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
            color: white;
        }

        .info-icon.success {
            background: linear-gradient(135deg, #1cc88a 0%, #17a673 100%);
            color: white;
        }

        .info-icon.warning {
            background: linear-gradient(135deg, #f6c23e 0%, #dda20a 100%);
            color: white;
        }

        .info-icon.info {
            background: linear-gradient(135deg, #36b9cc 0%, #2c9faf 100%);
            color: white;
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

            .stat-card {
                padding: 1.25rem;
            }
        }
    </style>

    <!-- Dashboard Header -->
    <div class="dashboard-header">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1>Dashboard Kepala BBWS</h1>
                <p>Selamat datang kembali, {{ auth()->user()->name }}!</p>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <!-- Statistics Cards -->
        <div class="row g-4">
            <!-- Card: Pengaduan Aktif -->
            <div class="col-md-6 col-lg-3">
                <div class="stat-card primary">
                    <div class="stat-icon primary">
                        <i class="fas fa-tasks"></i>
                    </div>
                    <div class="stat-title">Pengaduan Aktif</div>
                    <div class="stat-value">{{ $totalActive }}</div>
                </div>
            </div>

            <!-- Card: Pengaduan Selesai -->
            <div class="col-md-6 col-lg-3">
                <div class="stat-card success">
                    <div class="stat-icon success">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-title">Pengaduan Selesai</div>
                    <div class="stat-value">{{ $totalFinished }}</div>
                </div>
            </div>

            <!-- Card: Total Pemohon -->
            <div class="col-md-6 col-lg-3">
                <div class="stat-card info">
                    <div class="stat-icon info">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-title">Total Pemohon</div>
                    <div class="stat-value">{{ $totalPemohon }}</div>
                </div>
            </div>

            <!-- Card: Pending -->
            <div class="col-md-6 col-lg-3">
                <div class="stat-card warning">
                    <div class="stat-icon warning">
                        <i class="fas fa-hourglass-half"></i>
                    </div>
                    <div class="stat-title">Pending</div>
                    <div class="stat-value">{{ $pending }}</div>
                </div>
            </div>
        </div>

        <!-- Main Content Row -->
        <div class="row g-4 mt-2">
            <!-- Welcome Card -->
            <div class="col-xl-6 col-lg-6">
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
                            Bertugas memberikan keputusan akhir terhadap pengaduan masyarakat
                        </p>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="col-xl-6 col-lg-6">
                <div class="quick-actions">
                    <h5 class="section-title">Menu Keputusan</h5>

                    <a href="{{ route('kepalabbws.pengaduan.index') }}" class="action-btn">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon primary me-3" style="width: 40px; height: 40px; margin-bottom: 0;">
                                <i class="fas fa-gavel"></i>
                            </div>
                            <div>
                                <strong>Keputusan Pengaduan</strong>
                                <br>
                                <small class="text-muted">Review dan berikan keputusan akhir</small>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('kepalabbws.history.index') }}" class="action-btn">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon success me-3" style="width: 40px; height: 40px; margin-bottom: 0;">
                                <i class="fas fa-history"></i>
                            </div>
                            <div>
                                <strong>Riwayat Keputusan</strong>
                                <br>
                                <small class="text-muted">Lihat histori keputusan yang telah dibuat</small>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('kepalabbws.profile') }}" class="action-btn">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon info me-3" style="width: 40px; height: 40px; margin-bottom: 0;">
                                <i class="fas fa-user-cog"></i>
                            </div>
                            <div>
                                <strong>Profil Saya</strong>
                                <br>
                                <small class="text-muted">Kelola profil dan pengaturan akun</small>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>

    </div>
@endsection
