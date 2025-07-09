<nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top shadow-lg border-bottom">
    <div class="container">
        <!-- Logo dan Brand -->
        <a class="navbar-brand d-flex align-items-center" href="#hero">
            <img src="{{ asset('images/Logo_PU.jpg') }}" alt="PUPR Logo" class="me-2" style="height: 40px;">
            <div class="d-flex flex-column">
                <span class="fw-bold text-black fs-5">PUPR</span>
                <small class="text-muted" style="font-size: 0.7rem; line-height: 1;">Pengaduan Online</small>
            </div>
        </a>

        <!-- Mobile Toggle -->
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navigation Menu -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto ms-lg-4">
                <li class="nav-item">
                    <a class="nav-link fw-medium px-3" href="#hero">
                        <i class="bi bi-house-door me-1"></i>Beranda
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-medium px-3" href="#about">
                        <i class="bi bi-info-circle me-1"></i>Tentang
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-medium px-3" href="#how-it-works">
                        <i class="bi bi-gear me-1"></i>Cara Kerja
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-medium px-3" href="#contact">
                        <i class="bi bi-telephone me-1"></i>Kontak
                    </a>
                </li>
            </ul>

            <!-- Auth Buttons -->
            <ul class="navbar-nav d-flex flex-row">
                <li class="nav-item me-2">
                    <a class="btn btn-outline-primary px-4" href="{{ route('login') }}">
                        <i class="bi bi-box-arrow-in-right me-1"></i>Masuk
                    </a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-primary px-4" href="{{ route('register') }}">
                        <i class="bi bi-person-plus me-1"></i>Daftar
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<style>
    .navbar {
        backdrop-filter: blur(10px);
        background-color: rgba(255, 255, 255, 0.95) !important;
        transition: all 0.3s ease;
    }

    .nav-link {
        color: #495057 !important;
        transition: all 0.3s ease;
        border-radius: 8px;
        margin: 0 2px;
    }

    .nav-link:hover {
        color: #0d6efd !important;
        background-color: rgba(13, 110, 253, 0.1);
        transform: translateY(-1px);
    }

    .btn {
        border-radius: 25px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
</style>
