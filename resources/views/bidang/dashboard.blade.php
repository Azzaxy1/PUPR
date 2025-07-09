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

        .enhanced-card {
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

        .enhanced-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .enhanced-card.success {
            border-left: 5px solid #1cc88a;
        }

        .enhanced-card.warning {
            border-left: 5px solid #f6c23e;
        }

        .enhanced-card.info {
            border-left: 5px solid #36b9cc;
        }

        .enhanced-card::before {
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
            display: flex;
            align-items: center;
        }

        .stat-description i {
            margin-right: 0.5rem;
        }

        .welcome-card {
            background: linear-gradient(135deg, #f8f9fc 0%, #e9ecef 100%);
            border-radius: 15px;
            padding: 2rem;
            border: 2px solid #e3e6f0;
            position: relative;
            overflow: hidden;
            height: 100%;
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
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
            margin-bottom: 1rem;
            font-weight: 700;
        }
    </style>

    <!-- Dashboard Header -->
    <div class="dashboard-header">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1>Dashboard Bidang/Satker/SNVT</h1>
                <p>Selamat datang kembali, {{ auth()->user()->name }}!</p>
            </div>

        </div>
    </div>

    <div class="container-fluid py-4">
        <div class="row g-4">
            <!-- Card: Total Telaah -->
            <div class="col-md-6 col-lg-4">
                <div class="enhanced-card success">
                    <div class="stat-icon success">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-title">Total Telaah</div>
                    <div class="stat-value">{{ $totalApproved }}</div>
                    <div class="stat-description">
                        <i class="fas fa-arrow-up"></i>
                        Analisis teknis selesai
                    </div>
                </div>
            </div>

            <!-- Card: Pending Telaah -->
            <div class="col-md-6 col-lg-4">
                <div class="enhanced-card warning">
                    <div class="stat-icon warning">
                        <i class="fas fa-hourglass-half"></i>
                    </div>
                    <div class="stat-title">Pending Telaah</div>
                    <div class="stat-value">{{ $totalPending }}</div>
                    <div class="stat-description">
                        <i class="fas fa-{{ $totalPending > 0 ? 'exclamation-triangle' : 'check' }}"></i>
                        {{ $totalPending > 0 ? 'Memerlukan telaah' : 'Semua tertelaah' }}
                    </div>
                </div>
            </div>

            <!-- Card: Total Pengaduan -->
            <div class="col-md-6 col-lg-4">
                <div class="enhanced-card info">
                    <div class="stat-icon info">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <div class="stat-title">Total Pengaduan</div>
                    <div class="stat-value">{{ $totalApproved + $totalPending }}</div>
                    <div class="stat-description">
                        <i class="fas fa-arrow-up"></i>
                        Semua pengaduan masuk
                    </div>
                </div>
            </div>
        </div>

        <!-- Welcome Card Row -->
        <div class="row g-4 mt-2">
            <div class="col-12">
                <div class="welcome-card">
                    <div class="welcome-content">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <div class="d-flex align-items-center">
                                    <div class="welcome-avatar">
                                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                    </div>
                                    <div class="ms-3">
                                        <h4 class="mb-1">{{ auth()->user()->name }}</h4>
                                        <p class="text-muted mb-1">
                                            <i class="fas fa-user-tie me-2"></i>
                                            {{ auth()->user()->role->title }}
                                        </p>
                                        <p class="text-muted mb-0">
                                            <i class="fas fa-info-circle me-2"></i>
                                            Bertugas melakukan analisis teknis terhadap pengaduan yang masuk
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Table: Pengaduan Menunggu Telaah -->
        <div class="card shadow-sm border-0 mt-4">
            <div class="card-header bg-light">
                <h5 class="mb-0">Pengaduan Menunggu Telaah</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>No. Reg.</th>
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
                                        <a href="{{ route('bidang.pengaduan.edit', $report->id) }}"
                                            class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit me-1"></i> Telaah
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
