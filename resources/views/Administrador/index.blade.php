<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Administrador | MiServicio</title>
</head>
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
        height: 100vh;
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

    /* Sidebar */
    .sidebar {
        width: 250px;
        background-color: #111;
        color: white;
        display: flex;
        flex-direction: column;
        padding-top: 30px;
        position: fixed;
        height: 100%;
        top: 0;
        left: 0;
        box-shadow: 2px 0 5px rgba(0, 0, 0, 0.2);
    }

    .sidebar a {
        color: white;
        text-decoration: none;
        padding: 15px;
        font-size: 18px;
        transition: background-color 0.3s;
    }

    .sidebar a:hover {
        background-color: #444;
    }

    .sidebar a.active {
        background-color: #777;
    }

    /* Main content */
    .main-content {
        margin-left: 250px;
        flex: 1;
        padding: 20px;
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
    }

    /* Navbar */
    nav {
        background-color: #000;
        color: white;
        padding: 15px;
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

    /* Botones en el dashboard */
    .dashboard-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        margin-top: 20px;
    }

    .button {
        background-color: #00bcd4;
        color: white;
        padding: 15px 30px;
        border-radius: 8px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s, transform 0.3s;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .button:hover {
        background-color: #007c91;
        transform: translateY(-3px);
    }

    .button:active {
        transform: translateY(1px);
    }

    .button i {
        margin-right: 10px;
    }

    /* Contenido principal */
    .section {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
    }

    .section h2 {
        font-size: 24px;
        margin-bottom: 10px;
    }

    /* Footer */
    footer {
        background-color: #000;
        color: white;
        padding: 15px;
        text-align: center;
        font-size: 14px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .sidebar {
            width: 200px;
        }

        .main-content {
            margin-left: 200px;
        }
    }

</style>

<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <a href="#" class="active">Panel: Administrador</a>
        <a href="#">Usuarios</a>
        <a href="#">Servicios</a>
        <a href="#">Pagos</a>
        <a href="#">Auditoría</a>
        <a href="#">Estadísticas</a>
        <a href="#">Configuración</a>
    </div>

    <!-- Main content -->
    <div class="main-content">
        <!-- Navbar -->
        <nav>
            <div>
                <a href="#">MiServicio</a>
            </div>
            <div>
                <a href="logout">Cerrar sesión</a>
            </div>
        </nav>

        <!-- Dashboard -->
        <div class="section">
            <h2>Panel de Control</h2>
            <p>Bienvenido al panel de administración. Desde aquí puedes gestionar usuarios, servicios, pagos y mucho más.</p>
            <div class="dashboard-buttons">
                <div class="button"><i class="icon">&#128100;</i>Gestionar Usuarios</div>
                <div class="button"><i class="icon">&#128176;</i>Gestionar Pagos</div>
                <div class="button"><i class="icon">&#128211;</i>Reportes</div>
                <div class="button"><i class="icon">&#128297;</i>Auditoría</div>
                <div class="button"><i class="icon">&#128736;</i>Servicios</div>
            </div>
        </div>

        <!-- Estadísticas -->
        <div class="section">
            <h2>Estadísticas del Sistema</h2>
            <p>Gráficos y reportes sobre el uso del sistema y el rendimiento de los especialistas.</p>
            <!-- Aquí irían los gráficos o tablas -->
        </div>

        <!-- Footer -->
        <footer>
            &copy; 2025 MiServicio | Todos los derechos reservados.
        </footer>
    </div>

</body>
</html>
