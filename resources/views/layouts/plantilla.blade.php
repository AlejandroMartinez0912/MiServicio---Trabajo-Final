<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Boxicons para íconos modernos -->
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <title>@yield('titulo')</title>
  <style>
    /* Estilos del contenedor principal */
    .container-fluid {
      background-color: black; /* Fondo negro */
      padding: 10px 30px;
    }

    .container-fluid img {
      height: 80px;
      transition: transform 0.3s ease-in-out;
    }

    .container-fluid img:hover {
      transform: scale(1.1); /* Animación al pasar el cursor sobre el logo */
    }

    .navbar {
      background-color: black; /* Fondo negro */
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .navbar-nav .nav-link {
      color: #f8f9fa; /* Blanco */
      font-size: 1.1rem;
      transition: color 0.3s ease-in-out;
    }

    .navbar-nav .nav-link:hover {
      color: #0d6efd; /* Azul Bootstrap */
    }

    /* Estilos del contenido principal */
    .content {
      background-color: grey; /* Fondo gris más oscuro */
      padding: 20px;
      min-height: 80vh;
      border-radius: 8px; /* Agrega un borde redondeado */
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Sombra suave */
    }

    /* Footer moderno */
    footer {
      background-color: black; /* Fondo negro */
      padding: 20px 0;
      box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
    }

    footer .nav {
      justify-content: center; /* Centra horizontalmente los elementos */
    }

    footer .nav-link {
      color: #f8f9fa; /* Blanco suave */
      font-size: 0.9rem;
      margin: 0 15px; /* Espaciado horizontal entre los enlaces */
      transition: color 0.3s ease-in-out;
    }

    footer .nav-link:hover {
      color: #0d6efd; /* Azul Bootstrap */
    }

    /* Estilos de animación para botones y elementos */
    .navbar-toggler {
      border: none;
      outline: none;
    }

    .navbar-toggler-icon {
      transition: transform 0.3s ease-in-out;
    }

    .navbar-toggler:hover .navbar-toggler-icon {
      transform: rotate(90deg); /* Animación en el icono de menú */
    }
  </style>
</head>

<body>
  <!-- ENCABEZADO (NAVBAR) -->
  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="{{ route('home') }}">
        <img src="{{ asset('Images/logo.png') }}" alt="Logo de MiServicio">
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            @yield('ruta') <!-- Aquí se inserta la ruta específica según la vista -->
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- CONTENIDO PRINCIPAL -->
  <main class="content">
    @yield('contenido') <!-- Aquí se carga el contenido dinámico de cada página -->
  </main>

  <!-- ZONA FINAL (FOOTER) -->
  <footer class="footer mt-auto">
    <div class="container">
      <ul class="nav">
        <li class="nav-item"><a class="nav-link" href="#">Tutoriales</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Preguntas frecuentes</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Términos y condiciones</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Política de privacidad</a></li>
      </ul>
    </div>
  </footer>

  <!-- Bootstrap JS Bundle con Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Script para alertas-->
  <script>
      document.addEventListener('DOMContentLoaded', function () {
          @if(session('success'))
              Swal.fire({
                  icon: 'success',
                  title: 'Éxito',
                  text: '{{ session('success') }}',
                  confirmButtonText: 'Aceptar'
              });
          @endif
  
          @if(session('error'))
              Swal.fire({
                  icon: 'error',
                  title: 'Error',
                  text: '{{ session('error') }}',
                  confirmButtonText: 'Aceptar'
              });
          @endif
  
          @if(session('info'))
              Swal.fire({
                  icon: 'info',
                  title: 'Información',
                  text: '{{ session('info') }}',
                  confirmButtonText: 'Aceptar'
              });
          @endif
      });
    </script>
</body>

</html>
