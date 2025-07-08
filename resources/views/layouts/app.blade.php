<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title','MyApp')</title>
  <!-- Custom fonts for this template-->
  <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
  <link
      href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
      rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">

  {{-- ini akan inject <script>Alert::…</script> --}}
  @include('sweetalert::alert')

  @include('layouts.header')

  <main class="flex-grow-1 py-4">
    <div class="container">
      @yield('content')
    </div>
  </main>

  @include('layouts.footer')

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <!-- SweetAlert2 JS via CDN -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
  @stack('scripts')
</body>
</html>
