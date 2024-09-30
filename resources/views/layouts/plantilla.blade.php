<!DOCTYPE html>
<html lang="en">
<head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
  <title>@yield('titulo')</title>
</head>
<body>

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container-fluid">
        <a class="navbar-brand text-white" href="#">MiServicio</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item">
              @yield('ruta')
            </li>
          </ul>
        </div>
      </div>
    </nav>

  <main class="container mt-3">
    @yield('contenido')
  </main>

  <footer class="footer mt-auto navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <ul class="navbar-nav mx-auto">
        <li class="nav-item"><a class="nav-link text-white" href="#">Tutoriales</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="#">Preguntas frecuentes</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="#">Términos y condiciones</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="#">Política de privacidad</a></li>
      </ul>
    </div>
  </footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>