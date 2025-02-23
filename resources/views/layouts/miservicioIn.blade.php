<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo')</title>
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://unpkg.com/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">


    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>


    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap');
        * {
        font-family: "Montserrat", serif;
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        }

        /* Estilos básicos */
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #333, #1a1a1a, #000);
            background-size: 400% 400%;
            animation: gradientAnimation 15s ease infinite;
        }
        @keyframes gradientAnimation {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }

        /* Navbar */
        nav {
            background-color: black;
            color: white;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        nav a {
            color: white;
            text-decoration: none;
            padding: 10px;
            transition: background-color 0.3s;
        }

        nav a:hover {
            background-color: #444;
        }

        /* Main section */
        main {
            flex: 1;
            padding: 20px;
            margin: 10px 0;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }


        /* Footer */
        footer {
            background-color: black;
            color: white;
            padding: 10px 20px;
            text-align: center;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .section {
                width: 100%;
            }
        }
        img {
            width: 80px;
            height: auto;
        }

        .button-container {
            display: flex;
            background-color: black;
            width: 300px;
            height: 50px;
            align-items: center;
            justify-content: space-around;
            border-radius: 10px;
            }

            .button {
            outline: 0 !important;
            border: 0 !important;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: transparent;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            transition: all ease-in-out 0.3s;
            cursor: pointer;
            }

            .button:hover {
            transform: translateY(-3px);
            }

            .icon {
            font-size: 80px;
            }


    </style>

    <link rel="icon" href="{{ asset('Images/logo.png') }}" type="image/png">

</head>
<body>

    <!-- Navbar -->
    <nav>
        <a class="navbar-brand" href="{{ route('homein') }}">
            <img src="{{ asset('Images/logo.png') }}" alt="Logo de MiServicio">
        </a>
        <div class="button-container">
            <!-- home-->
            <button class="button">
                <a class="dropdown-item" href="{{ route('homein') }}" title="Inicio">
                    <i class="bx bx-home-alt-2"></i>
                </a>
            </button>
            
            <!-- perfil -->
            <button class="button">
                <a class="dropdown-item" href="{{ route('perfil') }}" title="Perfil">
                    <i class="bx bx-user"></i>
                </a>
            </button>
            <!-- gestion de servicios -->
            <button class="button">
                <a class="dropdown-item" href="{{ route('gestion-servicios') }}" title="Gestion de servicios">
                    <i class="bx bx-briefcase-alt"></i>
                </a>
            </button>
            <!-- informes -->
            <button class="button">
                <a class="dropdown-item" href="{{ route('informes') }}" title="Informes">
                    <i class="bx bx-file"></i>
                </a>
            </button>
            <!-- citas -->
            <button class="button">
                <a class="dropdown-item" href="{{ route('index-cita') }}" title="Mis citas">
                    <i class="bx bx-calendar"></i>
                </a>
            </button>
            <!-- Botón para Manual de Usuario en YouTube -->
            <button class="button">
                <a class="dropdown-item" href="https://www.youtube.com/playlist?list=PLvsZ4qDinLYez_YyDNvqMwHgCfqN1pzlL" 
                title="Manual de Usuario" target="_blank">
                    <i class="bx bxl-youtube"></i>
                </a>
            </button>

            
            <!-- salir -->
            <button class="button">
                <a class="dropdown-item" href="{{ route('logout') }}" title="Salir">
                    <i class="bx bx-log-out"></i>
                </a>
            </button>
        </div>
        
    </nav>

    <!-- Main content -->
    <main>
       @yield('contenido')
    </main>




   

    

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 MiServicio. Todos los derechos reservados.</p>
    </footer>

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
