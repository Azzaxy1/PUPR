{{-- resources/views/layouts/header.blade.php --}}
<nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top shadow-sm">
  <div class="container">
    <a class="navbar-brand" href="#hero">MyApp</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarNav" aria-controls="navbarNav"
            aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link" href="#hero">Beranda</a></li>
        <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
        <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
      </ul>
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Masuk</a></li>
        <li class="nav-item">
          <a class="btn btn-outline-dark ms-2" href="{{ route('register') }}">Daftar</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
