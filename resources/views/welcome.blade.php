<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="LAPOR!">
  <meta name="keywords" content="LAPOR!, Navbar, Scroll Effect">
  <meta name="author" content="Your Name">
  <title>@yield('title', 'PUPR')</title>
  <link href="{{ asset('images/Logo_PU.jpg') }}" rel="shortcut icon">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">

  <!-- Smooth scroll -->
  <style>
    html { scroll-behavior: smooth; }
    body { padding-top: 70px; } /* agar hero tidak tertutup navbar */
  </style>
</head>

<body>
  @include('layouts.header')

  <!-- Hero Section -->
  <div id="hero" class="hero text-white" style="background-color: #d32f2f; padding: 120px 0 80px;">
    <div class="container text-center">
      <h1 class="display-3 fw-bold">Layanan Aspirasi dan Pengaduan Online Rakyat</h1>
      <p class="lead">
        Sampaikan laporan Anda langsung kepada Balai Besar Wilayah Sungai Cidanau Ciujung Cidurian
      </p>
    </div>
  </div>

  <!-- About Section -->
  <section id="about" class="py-5 bg-light">
    <div class="container">
      <h2 class="fw-bold text-center mb-4">Tentang LAPOR!</h2>
      <p class="text-center mx-auto" style="max-width:720px;">
        LAPOR! adalah platform pengaduan online untuk mempercepat proses pelaporan dan penanganan aspirasi 
        masyarakat oleh Balai Besar Wilayah Sungai Cidanau Ciujung Cidurian. Kami memastikan setiap laporan 
        ditindaklanjuti dengan transparan dan akuntabel.
      </p>
    </div>
  </section>

  <!-- How It Works -->
  <section id="how-it-works" class="py-5">
    <div class="container">
      <h2 class="fw-bold text-center mb-4">Bagaimana Pengaduan Bekerja?</h2>
      <div class="d-flex justify-content-center gap-4 flex-wrap">
        <!-- Step 1 -->
        <div class="step text-center">
          <div class="icon bg-danger text-white rounded-circle p-3">
            <i class="bi bi-pencil-fill fs-3"></i>
          </div>
          <h6 class="fw-bold mt-2">Tulis Laporan</h6>
        </div>
        <!-- Step 2 -->
        <div class="step text-center">
          <div class="icon bg-light text-dark rounded-circle p-3">
            <i class="bi bi-arrow-right-circle fs-3"></i>
          </div>
          <h6 class="fw-bold mt-2">Proses Verifikasi</h6>
        </div>
        <!-- Step 3 -->
        <div class="step text-center">
          <div class="icon bg-light text-dark rounded-circle p-3">
            <i class="bi bi-chat-left-text fs-3"></i>
          </div>
          <h6 class="fw-bold mt-2">Proses Tindak Lanjut</h6>
        </div>
        <!-- Step 4 -->
        <div class="step text-center">
          <div class="icon bg-light text-dark rounded-circle p-3">
            <i class="bi bi-reply fs-3"></i>
          </div>
          <h6 class="fw-bold mt-2">Beri Tanggapan</h6>
        </div>
        <!-- Step 5 -->
        <div class="step text-center">
          <div class="icon bg-success text-white rounded-circle p-3">
            <i class="bi bi-check-circle fs-3"></i>
          </div>
          <h6 class="fw-bold mt-2">Selesai</h6>
        </div>
      </div>
    </div>
  </section>

  <!-- Contact Section -->
  <section id="contact" class="py-5 bg-light">
    <div class="container">
      <h2 class="fw-bold text-center mb-4">Hubungi Kami</h2>
      <div class="row justify-content-center">
        <div class="col-md-6">
          <ul class="list-unstyled">
            <li><strong>Alamat:</strong> Jl. Raya BBWS Cidanau Ciujung Cidurian</li>
            <li><strong>Telepon:</strong> (0254) 123456</li>
            <li><strong>Email:</strong> <a href="mailto:info@bbwsccc.go.id">info@bbwsccc.go.id</a></li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  @include('layouts.footer')

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Auto‐collapse navbar on link click -->
  <script>
    document.querySelectorAll('.navbar-collapse .nav-link[href^="#"]').forEach(link => {
      link.addEventListener('click', () => {
        const nav = document.getElementById('navbarNav');
        const bsCollapse = bootstrap.Collapse.getInstance(nav) || new bootstrap.Collapse(nav);
        bsCollapse.hide();
      });
    });
  </script>
  <!-- Custom JS -->
  <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
