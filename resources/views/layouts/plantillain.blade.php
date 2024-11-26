<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Boxicons para íconos modernos (opcional) -->
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

  <!-- jQuery (necesario si usas Select2) -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <!-- Select2 CSS y JS -->
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

  <!-- Popper.js -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>

  <!-- sweetalert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- Bootstrap CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">

  <!-- jQuery (necesario para los componentes de Bootstrap) -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <!-- Bootstrap JS -->
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>

  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">

  <title>@yield('titulo')</title>

  <style>
    /* Estilos generales */
    body {
      margin: 0;
      padding: 0;
      height: 100%;
      display: flex;
      flex-direction: column;
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
      position: relative;
      width: 100%;
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

    /* Contenido principal que ocupa el espacio restante */
    .content {
      flex: 1; /* Esto asegura que ocupe el espacio entre el encabezado y el pie de página */
      padding: 20px;
      background-color: gray; /* Fondo gris para diferenciar el contenido */
    }

    /* Ajustes para el contenedor que ocupa todo el ancho */
    .container {
      width: 100%;
      max-width: 100%; /* Asegura que el contenedor ocupe todo el ancho disponible */
    }

    /* Fondo de la página */
    .container-fluid {
      background-color: black;
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
          
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="dropdownMenuButton" role="button" 
               data-bs-toggle="dropdown" aria-expanded="false">
              <i class='bx bx-home-alt-2'></i> {{ Auth::user()->persona->nombre }}
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
              <li><a class="dropdown-item" href="{{ route('perfil') }}">
                <i class='bx bx-user'></i>  Perfil</a></li>

              <li><hr class="dropdown-divider"></li>

              <li><a class="dropdown-item" href="{{ route('gestion-servicios') }}">
                <i class='bx bx-donate-blood'></i> Gestion de servicios</a></li>

              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="{{ route('privada') }}">
                <i class='bx bx-search-alt-2'></i>  Buscar servicio</a></li>

              <li><a class="dropdown-item" href="{{ route('index-cita') }}">
                
                <i class='bx bx-list-check'></i> Mis Citas</a></li>
                <li><hr class="dropdown-divider"></li>

              <li><a class="dropdown-item text-danger" href="{{ route('logout') }}">
                <i class='bx bx-exit'></i>  Salir</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- CONTENIDO PRINCIPAL -->
  <main class="content">
    <div class="container">
      @yield('contenido')
    </div>
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
