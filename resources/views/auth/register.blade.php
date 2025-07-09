<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Daftar | PUPR Pengaduan Online</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ asset('images/Logo_PU.jpg') }}" rel="shortcut icon">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
            padding: 2rem 0;
        }

        /* Floating Shapes Background */
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
            animation: float 8s ease-in-out infinite;
        }

        .shape:nth-child(1) {
            width: 120px;
            height: 120px;
            top: 15%;
            left: 8%;
            animation-delay: 0s;
        }

        .shape:nth-child(2) {
            width: 180px;
            height: 180px;
            top: 60%;
            left: 88%;
            animation-delay: 3s;
        }

        .shape:nth-child(3) {
            width: 90px;
            height: 90px;
            top: 80%;
            left: 15%;
            animation-delay: 6s;
        }

        .shape:nth-child(4) {
            width: 140px;
            height: 140px;
            top: 25%;
            left: 85%;
            animation-delay: 1.5s;
        }

        .shape:nth-child(5) {
            width: 70px;
            height: 70px;
            top: 40%;
            left: 5%;
            animation-delay: 4.5s;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-30px) rotate(180deg);
            }
        }

        /* Main Card */
        .auth-container {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 450px;
            margin: 0 auto;
        }

        .auth-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 25px;
            box-shadow: 0 25px 70px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.2);
            overflow: hidden;
        }

        .auth-header {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(255, 255, 255, 0.7) 100%);
            padding: 2rem;
            text-align: center;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .auth-body {
            padding: 2.5rem;
        }

        .logo-container {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .logo-container img {
            width: 50px;
            height: 50px;
            border-radius: 10px;
        }

        .brand-text h3 {
            margin: 0;
            font-weight: 700;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .brand-text small {
            color: #6c757d;
            font-weight: 500;
        }

        /* Form Styling */
        .form-floating {
            margin-bottom: 1.5rem;
            position: relative;
        }

        .form-floating .form-control {
            height: 60px;
            border: 2px solid #e9ecef;
            border-radius: 15px;
            padding: 1rem 3.5rem 1rem 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.9);
        }

        .form-floating .form-control:focus {
            border-color: #764ba2;
            box-shadow: 0 0 0 0.2rem rgba(118, 75, 162, 0.15);
            background: white;
        }

        .form-floating label {
            padding: 1rem 1rem;
            color: #6c757d;
            font-weight: 500;
        }

        .input-icon {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            z-index: 5;
        }

        .form-control.is-invalid {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.15);
        }

        .invalid-feedback {
            display: block;
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }

        /* Password Match Indicator */
        .password-match {
            margin-top: 0.5rem;
            font-size: 0.875rem;
        }

        /* Buttons */
        .btn-auth {
            width: 100%;
            height: 60px;
            border-radius: 15px;
            font-weight: 600;
            font-size: 1.1rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            border: none;
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
            color: white;
            margin-bottom: 1.5rem;
        }

        .btn-auth:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 35px rgba(118, 75, 162, 0.4);
            color: white;
        }

        .btn-auth:active {
            transform: translateY(0);
        }

        /* Links */
        .auth-links {
            text-align: center;
            padding-top: 1rem;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
        }

        .auth-links a {
            color: #764ba2;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .auth-links a:hover {
            color: #667eea;
            text-decoration: underline;
        }

        .back-link {
            position: absolute;
            top: 2rem;
            left: 2rem;
            z-index: 20;
        }

        .back-link a {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.1);
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            backdrop-filter: blur(10px);
        }

        .back-link a:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateX(-5px);
            color: white;
        }

        /* Terms & Privacy */
        .terms-text {
            font-size: 0.875rem;
            color: #6c757d;
            text-align: center;
            margin-bottom: 1.5rem;
            line-height: 1.5;
        }

        .terms-text a {
            color: #764ba2;
            text-decoration: none;
        }

        .terms-text a:hover {
            text-decoration: underline;
        }

        /* Loading Animation */
        .btn-loading {
            position: relative;
            pointer-events: none;
        }

        .btn-loading::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            margin: auto;
            border: 2px solid transparent;
            border-top-color: white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Responsive */
        @media (max-width: 576px) {
            .auth-body {
                padding: 2rem 1.5rem;
            }

            .auth-header {
                padding: 1.5rem;
            }

            .back-link {
                top: 1rem;
                left: 1rem;
            }

            body {
                padding: 1rem 0;
            }
        }
    </style>
</head>

<body>
    {{-- SweetAlert --}}
    @include('sweetalert::alert')

    <!-- Floating Shapes Background -->
    <div class="floating-shapes">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>

    <!-- Back to Home Link -->
    <div class="back-link">
        <a href="{{ url('/') }}">
            <i class="bi bi-arrow-left"></i>
            <span>Kembali ke Beranda</span>
        </a>
    </div>

    <div class="container">
        <div class="auth-container">
            <div class="auth-card">
                <!-- Header -->
                <div class="auth-header">
                    <div class="logo-container">
                        <img src="{{ asset('images/Logo_PU.jpg') }}" alt="PUPR Logo">
                        <div class="brand-text">
                            <h3>PUPR</h3>
                            <small>Pengaduan Online</small>
                        </div>
                    </div>
                    <h4 class="mt-3 mb-0 fw-bold text-dark">Buat Akun Baru</h4>
                    <p class="text-muted mb-0">Daftar untuk mulai menggunakan layanan kami</p>
                </div>

                <!-- Form -->
                <div class="auth-body">
                    <form action="{{ route('register') }}" method="post" id="registerForm">
                        @csrf

                        <!-- Name Input -->
                        <div class="form-floating">
                            <input type="text" name="name" id="name"
                                class="form-control @error('name') is-invalid @enderror" placeholder="Nama Lengkap"
                                value="{{ old('name') }}" required autofocus>
                            <label for="name">Nama Lengkap</label>
                            <i class="bi bi-person input-icon"></i>
                            @error('name')
                                <div class="invalid-feedback">
                                    <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Email Input -->
                        <div class="form-floating">
                            <input type="email" name="email" id="email"
                                class="form-control @error('email') is-invalid @enderror" placeholder="nama@email.com"
                                value="{{ old('email') }}" required>
                            <label for="email">Alamat Email</label>
                            <i class="bi bi-envelope input-icon"></i>
                            @error('email')
                                <div class="invalid-feedback">
                                    <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Password Input -->
                        <div class="form-floating">
                            <input type="password" name="password" id="password"
                                class="form-control @error('password') is-invalid @enderror" placeholder="Password"
                                required>
                            <label for="password">Kata Sandi</label>
                            <i class="bi bi-lock input-icon toggle-password" style="cursor: pointer;"
                                data-target="password"></i>
                            @error('password')
                                <div class="invalid-feedback">
                                    <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Confirm Password Input -->
                        <div class="form-floating">
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="form-control" placeholder="Konfirmasi Password" required>
                            <label for="password_confirmation">Konfirmasi Kata Sandi</label>
                            <i class="bi bi-lock input-icon toggle-password" style="cursor: pointer;"
                                data-target="password_confirmation"></i>
                            <div class="password-match" id="passwordMatch"></div>
                        </div>

                        <!-- Terms & Privacy -->
                        <div class="terms-text">
                            Dengan mendaftar, Anda menyetujui
                            <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">Syarat & Ketentuan</a>
                            dan
                            <a href="#" data-bs-toggle="modal" data-bs-target="#privacyModal">Kebijakan
                                Privasi</a> kami.
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-auth" id="submitBtn">
                            <span class="btn-text">
                                <i class="bi bi-person-plus me-2"></i>Buat Akun Sekarang
                            </span>
                        </button>

                    </form>

                    <!-- Links -->
                    <div class="auth-links">
                        <p class="mb-0">
                            Sudah punya akun?
                            <a href="{{ route('login') }}">Masuk di sini</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Terms Modal -->
    <div class="modal fade" id="termsModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Syarat & Ketentuan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Dengan menggunakan layanan PUPR Pengaduan Online, Anda menyetujui:</p>
                    <ul>
                        <li>Memberikan informasi yang akurat dan benar</li>
                        <li>Tidak menyalahgunakan platform untuk hal-hal yang melanggar hukum</li>
                        <li>Menghormati privasi pengguna lain</li>
                        <li>Menggunakan layanan dengan bijak dan bertanggung jawab</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Privacy Modal -->
    <div class="modal fade" id="privacyModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Kebijakan Privasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Kami melindungi data pribadi Anda dengan:</p>
                    <ul>
                        <li>Enkripsi data tingkat tinggi</li>
                        <li>Akses terbatas hanya untuk petugas yang berwenang</li>
                        <li>Tidak membagikan data kepada pihak ketiga tanpa persetujuan</li>
                        <li>Penyimpanan data sesuai standar keamanan pemerintah</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>

    <script>
        // Toggle Password Visibility
        document.querySelectorAll('.toggle-password').forEach(icon => {
            icon.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                const passwordField = document.getElementById(targetId);

                if (passwordField.type === 'password') {
                    passwordField.type = 'text';
                    this.className = 'bi bi-eye-slash input-icon toggle-password';
                } else {
                    passwordField.type = 'password';
                    this.className = 'bi bi-lock input-icon toggle-password';
                }
            });
        });

        // Simple Password Confirmation Checker
        const passwordField = document.getElementById('password');
        const confirmPasswordField = document.getElementById('password_confirmation');
        const passwordMatch = document.getElementById('passwordMatch');

        function checkPasswordMatch() {
            const password = passwordField.value;
            const confirmPassword = confirmPasswordField.value;

            if (confirmPassword.length > 0) {
                if (password === confirmPassword) {
                    passwordMatch.innerHTML =
                        '<small style="color: #28a745;"><i class="bi bi-check-circle me-1"></i>Kata sandi cocok</small>';
                } else {
                    passwordMatch.innerHTML =
                        '<small style="color: #dc3545;"><i class="bi bi-x-circle me-1"></i>Kata sandi tidak cocok</small>';
                }
            } else {
                passwordMatch.innerHTML = '';
            }
        }

        // Event listeners for password confirmation
        passwordField.addEventListener('input', checkPasswordMatch);
        confirmPasswordField.addEventListener('input', checkPasswordMatch);

        // Form Submit Animation
        document.getElementById('registerForm').addEventListener('submit', function() {
            const submitBtn = document.getElementById('submitBtn');
            submitBtn.classList.add('btn-loading');
            submitBtn.innerHTML = '<span>Memproses...</span>';
        });

        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                if (alert.classList.contains('alert-success') || alert.classList.contains('alert-info')) {
                    alert.style.transition = 'opacity 0.5s';
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 500);
                }
            });
        }, 5000);
    </script>
</body>

</html>
