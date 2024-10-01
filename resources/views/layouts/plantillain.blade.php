<!DOCTYPE html>
<html lang="en">
<head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
  <title>
    @yield('titulo')</title>
  <style>
    body {
      background-color:slateblue;      
      background-size: cover;
      background-position: center;
      min-height: 100vh;  margin: 0;
      padding: 0;
    }
    .content {
      padding: 2rem; /* Add some padding for spacing */
      margin: 0 auto; /* Center the content horizontally */
      max-width: 800px; /* Set a maximum width for the content */
      border-radius: 5px; /* Add rounded corners for a smoother look */
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); /* Add a subtle shadow */
    }
  </style>
</head>
  <body>
    <!-- ENCABEZADO-->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
          <a class="navbar-brand text-white" href="{{ route('privada')}}">MiServicio</a>          
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
                          <li><a class="dropdown-item" href="{{ route('perfil') }}" style="color: black;">Perfil</a></li>
                          <li><hr class="dropdown-divider"></li>
                          <li><a class="dropdown-item" href="{{ route('home') }}" style="color: black;">Nueva empresa</a></li>
                          <li><a class="dropdown-item" href="{{ route('home') }}" style="color: black;">Mis empresas</a></li>
                          <li><hr class="dropdown-divider"></li>
                          <li><a class="dropdown-item" href="{{ route('home') }}" style="color: black;">Buscar servicio</a></li>
                          <li><a class="dropdown-item" href="{{ route('home') }}" style="color: black;">Mis turnos</a></li>
                          <li><hr class="dropdown-divider"></li>
                          <li><a class="dropdown-item text-danger" href="{{ route('logout') }}">Salir</a></li>
                      </ul>
                  </div>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    <!--ENCABEZADO -->

    
    <!--TITULO VISTA -->

    <!-- CONTENIDO PRINCIPAL-->
    <main class="content">
      @yield('contenido')
    </main>
    <!-- ZONA FINAL DEL DOCUMENTO-->
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