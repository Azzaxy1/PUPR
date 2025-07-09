<footer class="bg-dark text-white pt-5 pb-3">
    <div class="container">
        <!-- Main Footer Content -->
        <div class="row g-4">
            <!-- Brand Section -->
            <div class="col-lg-4 col-md-6">
                <div class="d-flex align-items-center mb-3">
                    <img src="{{ asset('images/Logo_PU.jpg') }}" alt="PUPR Logo" class="me-3" style="height: 50px;">
                    <div>
                        <h5 class="fw-bold mb-1">PUPR</h5>
                        <small class="text-light opacity-75">Pengaduan Online</small>
                    </div>
                </div>
                <p class="text-light opacity-75 mb-3">
                    Platform pengaduan resmi Balai Besar Wilayah Sungai Cidanau Ciujung Cidurian.
                    Melayani aspirasi masyarakat dengan transparan dan akuntabel.
                </p>

                <!-- Social Media -->
                <div class="d-flex gap-2">
                    <a href="#" class="btn btn-outline-light btn-sm rounded-circle pt-2"
                        style="width: 40px; height: 40px;">
                        <i class="bi bi-facebook"></i>
                    </a>
                    <a href="#" class="btn btn-outline-light btn-sm rounded-circle pt-2"
                        style="width: 40px; height: 40px;">
                        <i class="bi bi-twitter"></i>
                    </a>
                    <a href="#" class="btn btn-outline-light btn-sm rounded-circle pt-2"
                        style="width: 40px; height: 40px;">
                        <i class="bi bi-instagram"></i>
                    </a>
                    <a href="#" class="btn btn-outline-light btn-sm rounded-circle pt-2"
                        style="width: 40px; height: 40px;">
                        <i class="bi bi-youtube"></i>
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="col-lg-2 col-md-6">
                <h6 class="fw-bold mb-3">Menu Utama</h6>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <a href="#hero" class="text-light opacity-75 text-decoration-none hover-link">
                            <i class="bi bi-chevron-right me-1"></i>Beranda
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#about" class="text-light opacity-75 text-decoration-none hover-link">
                            <i class="bi bi-chevron-right me-1"></i>Tentang
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#how-it-works" class="text-light opacity-75 text-decoration-none hover-link">
                            <i class="bi bi-chevron-right me-1"></i>Cara Kerja
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#contact" class="text-light opacity-75 text-decoration-none hover-link">
                            <i class="bi bi-chevron-right me-1"></i>Kontak
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Services -->
            <div class="col-lg-3 col-md-6">
                <h6 class="fw-bold mb-3">Layanan</h6>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <a href="{{ route('register') }}" class="text-light opacity-75 text-decoration-none hover-link">
                            <i class="bi bi-chevron-right me-1"></i>Buat Laporan
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('login') }}" class="text-light opacity-75 text-decoration-none hover-link">
                            <i class="bi bi-chevron-right me-1"></i>Cek Status Laporan
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div class="col-lg-3 col-md-6">
                <h6 class="fw-bold mb-3">Informasi Kontak</h6>
                <div class="d-flex align-items-start mb-3">
                    <i class="bi bi-geo-alt me-3 mt-1 text-primary"></i>
                    <div>
                        <small class="text-light opacity-75">
                            Jl. Raya BBWS Cidanau Ciujung Cidurian<br>
                            Serang, Banten 42121
                        </small>
                    </div>
                </div>

                <div class="d-flex align-items-center mb-2">
                    <i class="bi bi-telephone me-3 text-primary"></i>
                    <small class="text-light opacity-75">(0254) 123456</small>
                </div>

                <div class="d-flex align-items-center mb-2">
                    <i class="bi bi-envelope me-3 text-primary"></i>
                    <small class="text-light opacity-75">info@bbwsccc.go.id</small>
                </div>

                <div class="d-flex align-items-center">
                    <i class="bi bi-clock me-3 text-primary"></i>
                    <small class="text-light opacity-75">24/7 Online Service</small>
                </div>
            </div>
        </div>

        <!-- Divider -->
        <hr class="my-4 opacity-25">

        <!-- Bottom Footer -->
        <div class="row align-items-center">
            <div class="col-md-6">
                <small class="text-light opacity-75">
                    &copy; {{ date('Y') }} PUPR - Kementerian Pekerjaan Umum dan Perumahan Rakyat.
                    All Rights Reserved.
                </small>
            </div>
            <div class="col-md-6 text-md-end">
                <small class="text-light opacity-75">
                    <a href="#" class="text-light opacity-75 text-decoration-none me-3 hover-link">Privacy
                        Policy</a>
                    <a href="#" class="text-light opacity-75 text-decoration-none hover-link">Terms of Service</a>
                </small>
            </div>
        </div>
    </div>
</footer>

<style>
    .hover-link {
        transition: all 0.3s ease;
    }

    .hover-link:hover {
        opacity: 1 !important;
        color: #0d6efd !important;
        transform: translateX(5px);
    }

    footer {
        background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%) !important;
    }
</style>
