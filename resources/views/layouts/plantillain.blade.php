<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Boxicons para íconos modernos -->
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <title>@yield('titulo')</title>

  <style>
    /* Estilos generales */
    body {
      background-color: #f8f9fa; /* Fondo claro */
      margin: 0;
      padding: 0;
      min-height: 100vh;
    }

    /* Estilos del contenedor principal */
    .container-fluid {
      background-color: black; /* Fondo negro */
      padding: 10px 30px;
    }

    .container-fluid img {
      height: 80px; /* Ajuste de tamaño del logo */
      transition: transform 0.3s ease-in-out;
    }

    .container-fluid img:hover {
      transform: scale(1.1); /* Efecto hover en el logo */
    }

    .navbar {
      background-color: black; /* Fondo negro */
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .navbar-nav .nav-link {
      color: #f8f9fa; /* Blanco */
      transition: color 0.3s ease-in-out;
    }

    .navbar-nav .nav-link:hover {
      color: #0d6efd; /* Azul Bootstrap */
    }

    /* Footer estilizado */
    footer {
      background-color: black;
      padding: 20px 0;
      box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
    }

    footer .nav {
      justify-content: center;
    }

    footer .nav-link {
      color: #f8f9fa;
      margin: 0 15px;
      transition: color 0.3s ease-in-out;
    }

    footer .nav-link:hover {
      color: #0d6efd;
    }

    /* Dropdown estilizado */
    .dropdown-item {
      color: black;
    }

    .dropdown-item.text-danger {
      color: red;
    }

    .dropdown-menu {
      min-width: 200px;
    }

    /* Estilos del contenido */
    .content {
      background-color: #ffffff; /* Fondo blanco */
      padding: 20px;
      min-height: 80vh;
    }

    /* Estilos para el botón del menú */
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
      <a class="navbar-brand" href="{{ route('privada') }}">
        <img src="{{ asset('Images/logo.png') }}" alt="Logo de MiServicio">
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <div class="dropdown">
              <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                Mi Cuenta
              </button>
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                <li><a class="dropdown-item" href="{{ route('perfil') }}">Perfil</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="{{ route('home') }}">Nueva empresa</a></li>
                <li><a class="dropdown-item" href="{{ route('home') }}">Mis empresas</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="{{ route('home') }}">Buscar servicio</a></li>
                <li><a class="dropdown-item" href="{{ route('home') }}">Mis turnos</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-danger" href="{{ route('logout') }}">Salir</a></li>
              </ul>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- CONTENIDO PRINCIPAL -->
  <main class="content">
    @yield('contenido')
  </main>

  <!-- FOOTER -->
  <footer class="footer mt-auto">
    <div class="container">
      <ul class="nav justify-content-center">
        <li class="nav-item"><a class="nav-link" href="#">Tutoriales</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Preguntas frecuentes</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Términos y condiciones</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Política de privacidad</a></li>
      </ul>
    </div>
  </footer>

  <!-- Bootstrap JS Bundle con Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
