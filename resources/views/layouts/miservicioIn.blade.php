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
            <!-- citas -->
            <button class="button">
                <a class="dropdown-item" href="{{ route('index-cita') }}" title="Mis citas">
                    <i class="bx bx-calendar"></i>
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


<!-- Modal de Calificación -->
<div class="modal" id="calificacionModal" style="display: none;">
    <div class="modal-content">
        <h3>Calificar Servicio</h3>
        <!-- Formulario para calificar -->
        <form id="calificacionForm" method="POST" action="" data-id-cita="">
            @csrf <!-- Token CSRF de Laravel para seguridad -->
            <input type="hidden" id="citaId" name="idCita"> <!-- Campo oculto para idCita -->
            <div>
                <label for="calificacion">Calificación:</label>
                <select name="calificacion" id="calificacion">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>
            <div>
                <label for="comentario">Comentario:</label>
                <textarea name="comentario" id="comentario" rows="4"></textarea>
            </div>
            <div>
                <button type="submit">Guardar Calificación</button>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function () {
        // Obtener las citas pendientes
        $.ajax({
            url: '/calificaciones/pendientes', // Aquí está la URL donde consultas las citas pendientes
            type: 'GET',
            success: function (data) {
                // Verificamos si hay citas pendientes
                if (data.length > 0) {
                    var cita = data[0]; // Tomamos la primera cita pendiente (puedes modificar según tu caso)
                    $('#citaId').val(cita.idCita); // Asignamos el id de la cita al campo oculto
                    
                    // Establecemos la acción del formulario (esto se hace dinámicamente según el id de la cita)
                    $('#calificacionForm').attr('action', '/calificaciones/' + cita.idCita + '/guardar');
                    
                    // Mostramos el modal
                    $('#calificacionModal').show();
                }
            },
            error: function () {
                alert('Hubo un error al obtener las citas pendientes.');
            }
        });

        // Cuando se envíe el formulario
        $('#calificacionForm').submit(function(event) {
            event.preventDefault(); // Prevenir el envío automático del formulario

            var form = $(this); // Obtener el formulario

            // Enviar el formulario de forma convencional
            form.unbind('submit').submit(); // Enviar el formulario manualmente
        });
    });
</script>
<style>
    /* Modal */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 9999;
        justify-content: center;
        align-items: center;
    }

    .modal-content {
        background-color: #333;
        padding: 30px;
        border-radius: 8px;
        width: 400px;
        max-width: 90%;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        text-align: center;
        color: #fff;
        font-family: 'Arial', sans-serif;
    }

    .modal h3 {
        font-size: 26px;
        color: #fff;
        margin-bottom: 20px;
        font-weight: 600;
        text-transform: uppercase;
    }

    .modal form {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .modal label {
        font-size: 16px;
        color: #fff;
        margin-bottom: 8px;
        text-align: left;
        font-weight: 500;
    }

    .modal select,
    .modal textarea {
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 16px;
        width: 100%;
        box-sizing: border-box;
        background-color: #222;
        color: #fff;
    }

    .modal textarea {
        resize: vertical;
    }

    .modal button {
        padding: 12px 25px;
        background-color: #ff00cc;
        color: #fff;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        text-transform: uppercase;
    }

    .modal button:hover {
        background-color: #333399;
    }

    /* Estilo del fondo oscuro de la pantalla */
    .modal {
        display: flex;
    }

    /* Botón de cerrar el modal */
    .close-btn {
        background-color: transparent;
        border: none;
        color: #fff;
        font-size: 25px;
        cursor: pointer;
        position: absolute;
        top: 15px;
        right: 15px;
    }

    .close-btn:hover {
        color: #ff00cc;
    }

    /* Animación de entrada para el modal */
    .modal-content {
        animation: fadeIn 0.4s ease-in-out;
    }

    @keyframes fadeIn {
        0% {
            opacity: 0;
            transform: scale(0.8);
        }
        100% {
            opacity: 1;
            transform: scale(1);
        }
    }
</style>

   

    

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
