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

<!-- Modal -->
<div class="modal fade" id="calificacionModal" tabindex="-1" aria-labelledby="calificacionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="calificacionModalLabel">Califica tu cita</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="calificacionForm" action="" method="POST"> <!-- Acción vacía inicialmente -->
                    @csrf
                    <input type="hidden" id="citaId" name="citaId">
                    <div id="detalleCita"></div>

                    <div class="mb-3">
                        <label>Calificación:</label>
                        <div id="estrellas">
                            <span class="star" data-index="1">&#9733;</span>
                            <span class="star" data-index="2">&#9733;</span>
                            <span class="star" data-index="3">&#9733;</span>
                            <span class="star" data-index="4">&#9733;</span>
                            <span class="star" data-index="5">&#9733;</span>
                        </div>
                        <input type="hidden" id="calificacion" name="calificacion">
                    </div>

                    <div id="opcionesMotivos" style="display: none;">
                        <p>Selecciona un motivo:</p>
                        <button type="button" class="btn btn-outline-light" data-motivo="Tiempo de espera">Tiempo de espera</button>
                        <button type="button" class="btn btn-outline-light" data-motivo="Calidad del servicio">Calidad del servicio</button>
                        <button type="button" class="btn btn-outline-light" data-motivo="Atención recibida">Atención recibida</button>
                    </div>

                    <div id="comentarioAdicional" style="display: none;">
                        <textarea id="comentarios" name="comentarios" class="form-control" placeholder="Comentario adicional"></textarea>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" id="calificarBtn" class="btn btn-primary">Enviar Calificación</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    let citaId = null;
    let calificacion = 0;
    let motivoSeleccionado = null;

    function verificarCalificacionesPendientes() {
        $.get('/calificaciones-pendientes', function(data) {
            if (data.pendientes.length > 0) {
                const cita = data.pendientes[0];
                citaId = cita.idCita;
                $('#citaId').val(citaId);  // Asignar el idCita al campo oculto
                $('#detalleCita').text(`Tienes pendiente calificar el servicio del ${cita.fechaCita}.`);

                // Actualizar la acción del formulario con el idCita
                $('#calificacionForm').attr('action', '/guardar-calificacion-cliente/' + citaId); // Construir la URL correctamente

                const modal = new bootstrap.Modal(document.getElementById('calificacionModal'));
                modal.show();
            }
        }).fail(function() {
            console.error('Error al verificar citas pendientes.');
        });
    }

    $(document).ready(function() {
        verificarCalificacionesPendientes();

        $('.star').on('click', function() {
            calificacion = $(this).data('index');
            $('#calificacion').val(calificacion);
            $('.star').each(function(index) {
                $(this).toggleClass('text-warning', index < calificacion);
            });

            if (calificacion < 5) {
                $('#opcionesMotivos').show();
                $('#comentarioAdicional').show();
            } else {
                $('#opcionesMotivos').hide();
                $('#comentarioAdicional').hide();
            }
        });

        $('#opcionesMotivos button').on('click', function() {
            motivoSeleccionado = $(this).data('motivo');
            $('#opcionesMotivos button').removeClass('btn-primary').addClass('btn-outline-light');
            $(this).removeClass('btn-outline-light').addClass('btn-primary');
        });

        // Si se selecciona un motivo, se coloca en el campo de comentarios
        $('#opcionesMotivos button').on('click', function() {
            $('#comentarios').val(motivoSeleccionado);
        });
    });
</script>

<!-- Estilos para el modal -->
<style>
    .star {
        font-size: 1.8rem;
        cursor: pointer;
        color: #ccc; /* Color de estrellas desactivadas */
        transition: color 0.3s;
    }

    .star.text-warning {
        color: #ff00cc; /* Color de estrellas seleccionadas */
    }

    .modal-content {
        background-color: #333;
        color: white;
    }

    .modal-header, .modal-footer {
        border: none;
        background-color: #333;
    }

    .modal-header .btn-close {
        color: #ff00cc;
    }

    #opcionesMotivos button {
        margin-right: 8px;
        margin-top: 10px;
        transition: transform 0.2s ease-in-out;
        border: 1px solid #ff00cc;
        color: #ff00cc;
        background-color: transparent;
    }

    #opcionesMotivos button:hover {
        transform: scale(1.05);
        background-color: #ff00cc;
        color: #333;
    }

    #comentarios {
        background-color: #333;
        color: white;
        border: 1px solid #ff00cc;
    }

    .btn-outline-light {
        border: 1px solid #ff00cc;
        color: #ff00cc;
    }

    .btn-outline-light:hover {
        background-color: #ff00cc;
        color: #333;
    }

    .btn-primary {
        background-color: #ff00cc;
        border: none;
    }

    .btn-primary:hover {
        background-color: #cc00b3;
    }

    /* Ajustes adicionales para los botones dentro del modal */
    .modal-footer .btn {
        background-color: #ff00cc;
        border: none;
    }

    .modal-footer .btn:hover {
        background-color: #cc00b3;
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
