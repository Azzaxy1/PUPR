<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Layanan Aspirasi dan Pengaduan Online Rakyat - PUPR">
    <meta name="keywords" content="PUPR, Pengaduan, Aspirasi, BBWS, Cidanau, Ciujung, Cidurian">
    <meta name="author" content="PUPR">
    <title>@yield('title', 'PUPR - Pengaduan Online')</title>
    <link href="{{ asset('images/Logo_PU.jpg') }}" rel="shortcut icon">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            padding-top: 80px;
            line-height: 1.6;
        }

        /* Hero Section */
        .hero-gradient {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            position: relative;
            overflow: hidden;
        }

        .hero-gradient::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
        }

        .floating-shapes {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 1;
        }

        .shape {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }

        .shape:nth-child(1) {
            width: 80px;
            height: 80px;
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }

        .shape:nth-child(2) {
            width: 120px;
            height: 120px;
            top: 60%;
            left: 80%;
            animation-delay: 2s;
        }

        .shape:nth-child(3) {
            width: 60px;
            height: 60px;
            top: 80%;
            left: 20%;
            animation-delay: 4s;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-20px) rotate(180deg);
            }
        }

        /* Cards */
        .feature-card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            border: none;
            height: 100%;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        }

        .icon-wrapper {
            width: 80px;
            height: 80px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        /* Step Cards */
        .step-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            text-align: center;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            position: relative;
            margin-bottom: 2rem;
        }

        .step-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }

        .step-number {
            position: absolute;
            top: -15px;
            left: 50%;
            transform: translateX(-50%);
            width: 30px;
            height: 30px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .step-icon {
            width: 60px;
            height: 60px;
            border-radius: 15px;
            margin: 1rem auto;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
        }

        .step-card:nth-child(2) .step-icon {
            background: linear-gradient(135deg, #4834d4 0%, #686de0 100%);
        }

        .step-card:nth-child(3) .step-icon {
            background: linear-gradient(135deg, #ff9ff3 0%, #f368e0 100%);
        }

        .step-card:nth-child(4) .step-icon {
            background: linear-gradient(135deg, #54a0ff 0%, #2e86de 100%);
        }

        .step-card:nth-child(5) .step-icon {
            background: linear-gradient(135deg, #5f27cd 0%, #00d2d3 100%);
        }

        /* Statistics */
        .stats-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(255, 255, 255, 0.7) 100%);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 2rem;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .stats-number {
            font-size: 3rem;
            font-weight: 700;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* CTA Button */
        .cta-button {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
            border: none;
            border-radius: 50px;
            padding: 1rem 3rem;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .cta-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(255, 107, 107, 0.4);
        }

        /* Section Dividers */
        .section-divider {
            height: 1px;
            background: linear-gradient(to right, transparent, #e9ecef, transparent);
            margin: 4rem 0;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-gradient {
                padding: 60px 0 40px;
            }

            .stats-number {
                font-size: 2rem;
            }

            .feature-card {
                padding: 1.5rem;
            }
        }
    </style>
</head>

<body>
    @include('layouts.header')

    <!-- Hero Section -->
    <section id="hero" class="hero-gradient text-white position-relative">
        <div class="floating-shapes">
            <div class="shape"></div>
            <div class="shape"></div>
            <div class="shape"></div>
        </div>

        <div class="container position-relative" style="z-index: 2;">
            <div class="row align-items-center min-vh-100 py-5">
                <div class="col-lg-6" data-aos="fade-right">
                    <h1 class="display-4 fw-bold mb-4">
                        Layanan Aspirasi & Pengaduan Online
                        <span class="text-warning">Rakyat</span>
                    </h1>
                    <p class="lead mb-4 opacity-90">
                        Sampaikan laporan Anda langsung kepada Balai Besar Wilayah Sungai Cidanau Ciujung Cidurian.
                        Transparan, akuntabel, dan responsif.
                    </p>

                    <div class="d-flex flex-wrap gap-3 mb-5">
                        <a href="{{ route('register') }}" class="btn cta-button text-white">
                            <i class="bi bi-plus-circle me-2"></i>Buat Laporan
                        </a>
                        <a href="#how-it-works" class="btn btn-outline-light border-2 px-4 pt-3">
                            <i class="bi bi-play-circle me-2"></i>Cara Kerja
                        </a>
                    </div>
                </div>

                <div class="col-lg-6 text-center" data-aos="fade-left">
                    <img src="{{ asset('images/balai.png') }}" alt="Illustration" class="img-fluid"
                        style="max-height: 400px;">
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="about" class="py-5">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-8 text-center" data-aos="fade-up">
                    <h2 class="fw-bold mb-4">Mengapa Memilih PUPR Pengaduan?</h2>
                    <p class="lead text-muted">
                        Platform pengaduan terdepan dengan teknologi modern untuk melayani aspirasi masyarakat
                    </p>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="feature-card">
                        <div class="icon-wrapper">
                            <i class="bi bi-shield-check text-white fs-2"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Aman & Terpercaya</h5>
                        <p class="text-muted">
                            Data Anda aman dengan enkripsi tingkat tinggi dan sistem keamanan berlapis
                        </p>
                    </div>
                </div>

                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="feature-card">
                        <div class="icon-wrapper">
                            <i class="bi bi-lightning-charge text-white fs-2"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Respon Cepat</h5>
                        <p class="text-muted">
                            Tim profesional kami siap merespon laporan Anda dalam waktu 24 jam
                        </p>
                    </div>
                </div>

                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="feature-card">
                        <div class="icon-wrapper">
                            <i class="bi bi-graph-up text-white fs-2"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Tracking Real-time</h5>
                        <p class="text-muted">
                            Pantau progress laporan Anda secara real-time dari awal hingga selesai
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- How It Works -->
    <section id="how-it-works" class="py-5 bg-light">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-8 text-center" data-aos="fade-up">
                    <h2 class="fw-bold mb-4">Bagaimana Cara Kerjanya?</h2>
                    <p class="lead text-muted">
                        Proses pengaduan yang sederhana dan transparan dalam 5 langkah mudah
                    </p>
                </div>
            </div>

            <div class="row g-4 text-center d-flex justify-content-center">
                <div class="col-lg-2 col-md-4 col-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="step-card">
                        <div class="step-number">1</div>
                        <div class="step-icon">
                            <i class="bi bi-pencil-fill text-white fs-4"></i>
                        </div>
                        <h6 class="fw-bold">Tulis Laporan</h6>
                        <small class="text-muted">Buat akun dan tulis laporan Anda</small>
                    </div>
                </div>

                <div class="col-lg-2 col-md-4 col-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="step-card">
                        <div class="step-number">2</div>
                        <div class="step-icon">
                            <i class="bi bi-search text-white fs-4"></i>
                        </div>
                        <h6 class="fw-bold">Verifikasi</h6>
                        <small class="text-muted">Tim kami verifikasi laporan</small>
                    </div>
                </div>

                <div class="col-lg-2 col-md-4 col-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="step-card">
                        <div class="step-number">3</div>
                        <div class="step-icon">
                            <i class="bi bi-gear-fill text-white fs-4"></i>
                        </div>
                        <h6 class="fw-bold">Proses</h6>
                        <small class="text-muted">Analisis oleh bidang teknis</small>
                    </div>
                </div>

                <div class="col-lg-2 col-md-4 col-6" data-aos="fade-up" data-aos-delay="400">
                    <div class="step-card">
                        <div class="step-number">4</div>
                        <div class="step-icon">
                            <i class="bi bi-chat-dots text-white fs-4"></i>
                        </div>
                        <h6 class="fw-bold">Tanggapan</h6>
                        <small class="text-muted">Kepala BBWS memberikan respon</small>
                    </div>
                </div>

                <div class="col-lg-2 col-md-4 col-6" data-aos="fade-up" data-aos-delay="500">
                    <div class="step-card">
                        <div class="step-number">5</div>
                        <div class="step-icon">
                            <i class="bi bi-check-circle-fill text-white fs-4"></i>
                        </div>
                        <h6 class="fw-bold">Selesai</h6>
                        <small class="text-muted">Laporan selesai diproses</small>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Contact Section -->
    <section id="contact" class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8" data-aos="fade-up">
                    <div class="feature-card text-center">
                        <h2 class="fw-bold mb-4">Hubungi Kami</h2>
                        <p class="lead text-muted mb-4">
                            Tim kami siap membantu Anda 24/7
                        </p>

                        <div class="row g-4 mt-4">
                            <div class="col-md-4 d-flex align-items-center justify-content-center">
                                <div class="d-flex align-items-center">
                                    <div class="icon-wrapper me-3" style="width: 50px; height: 50px;">
                                        <i class="bi bi-geo-alt text-white"></i>
                                    </div>
                                    <div class="text-start">
                                        <strong>Alamat</strong><br>
                                        <small class="text-muted">Jl. Raya BBWS Cidanau Ciujung Cidurian</small>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 d-flex align-items-center justify-content-center">
                                <div class="d-flex align-items-center">
                                    <div class="icon-wrapper me-3" style="width: 50px; height: 50px;">
                                        <i class="bi bi-telephone text-white"></i>
                                    </div>
                                    <div class="text-start">
                                        <strong>Telepon</strong><br>
                                        <small class="text-muted">(0254) 123456</small>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 d-flex align-items-center justify-content-center">
                                <div class="d-flex align-items-center">
                                    <div class="icon-wrapper me-3" style="width: 50px; height: 50px;">
                                        <i class="bi bi-envelope text-white"></i>
                                    </div>
                                    <div class="text-start">
                                        <strong>Email</strong><br>
                                        <small class="text-muted">info@bbwsccc.go.id</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('layouts.footer')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AOS Animation -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            once: true,
            offset: 100
        });

        // Auto‐collapse navbar on link click
        document.querySelectorAll('.navbar-collapse .nav-link[href^="#"]').forEach(link => {
            link.addEventListener('click', () => {
                const nav = document.getElementById('navbarNav');
                const bsCollapse = bootstrap.Collapse.getInstance(nav) || new bootstrap.Collapse(nav);
                bsCollapse.hide();
            });
        });

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 100) {
                navbar.style.backgroundColor = 'rgba(255, 255, 255, 0.98)';
                navbar.style.boxShadow = '0 2px 20px rgba(0,0,0,0.1)';
            } else {
                navbar.style.backgroundColor = 'rgba(255, 255, 255, 0.95)';
                navbar.style.boxShadow = '0 2px 10px rgba(0,0,0,0.05)';
            }
        });
    </script>
</body>

</html>
