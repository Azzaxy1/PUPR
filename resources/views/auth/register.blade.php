<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Register | MyApp</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/icheck-bootstrap@3.0.1/icheck-bootstrap.min.css">
  <!-- AdminLTE -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <!-- SweetAlert2 CSS via CDN -->
  <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
</head>
<body class="hold-transition register-page">
  {{-- SweetAlert --}}
  @include('sweetalert::alert')

  <div class="register-box">
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <a href="{{ url('/') }}" class="h1"><b>My</b>App</a>
      </div>
      <div class="card-body">
        <p class="login-box-msg">Register a new membership</p>

        <form action="{{ route('register') }}" method="post">
          @csrf

          <div class="input-group mb-3">
            <input 
              type="text" 
              name="name" 
              class="form-control @error('name') is-invalid @enderror" 
              placeholder="Full name" 
              value="{{ old('name') }}" 
              required 
              autofocus>
            <div class="input-group-append">
              <div class="input-group-text"><span class="fas fa-user"></span></div>
            </div>
            @error('name')
              <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
          </div>

          <div class="input-group mb-3">
            <input 
              type="email" 
              name="email" 
              class="form-control @error('email') is-invalid @enderror" 
              placeholder="Email" 
              value="{{ old('email') }}" 
              required>
            <div class="input-group-append">
              <div class="input-group-text"><span class="fas fa-envelope"></span></div>
            </div>
            @error('email')
              <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
          </div>

          <div class="input-group mb-3">
            <input 
              type="password" 
              name="password" 
              class="form-control @error('password') is-invalid @enderror" 
              placeholder="Password" 
              required>
            <div class="input-group-append">
              <div class="input-group-text"><span class="fas fa-lock"></span></div>
            </div>
            @error('password')
              <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
          </div>

          <div class="input-group mb-3">
            <input 
              type="password" 
              name="password_confirmation" 
              class="form-control" 
              placeholder="Retype password" 
              required>
            <div class="input-group-append">
              <div class="input-group-text"><span class="fas fa-lock"></span></div>
            </div>
          </div>

          <div class="row">
            <div class="col-8">
              <a href="{{ route('login') }}" class="text-center">I already have a membership</a>
            </div>
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block">Register</button>
            </div>
          </div>

        </form>
      </div>
    </div>
  </div>

  <!-- jQuery (required by AdminLTE) -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- Bootstrap 5 -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
  <!-- SweetAlert2 JS via CDN -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
</body>
</html>
