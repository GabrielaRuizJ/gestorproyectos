<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestor de Tareas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .hero-section {
            background: linear-gradient(to right, #232455ff, #2575fc);
            color: white;
            padding: 100px 0;
            text-align: center;
        }
        .info-section {
            padding: 60px 0;
        }
        .card {
            border: none;
            box-shadow: 0 4px 8px rgba(0,0,0,.1);
        }
        .footer {
            background-color: #343a40;
            color: white;
            padding: 20px 0;
            text-align: center;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Gestor de proyectos GR</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link " href="#" data-bs-toggle="modal" data-bs-target="#iniciosesion">
                            Iniciar sesión   
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="#" data-bs-toggle="modal" data-bs-target="#RegistroModal">
                           Registro
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <header class="hero-section">
        <div class="container">
            <h1 class="display-4">Organiza tu vida con el Gestor de Proyectos</h1>
            <p class="lead">Simplifica tu día a día, aumenta tu productividad y no olvides nada importante.</p>
            <a href="#" class="btn btn-light btn-lg mt-3" id="mainActionBtn">Empezar Ahora</a>
        </div>
    </header>

    <section class="info-section">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-4">
                    <div class="card p-4 mb-4">
                        <h3 class="card-title">Gestión Intuitiva</h3>
                        <p class="card-text">Crea, edita y organiza tus proyectos de forma sencilla y eficiente.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card p-4 mb-4">
                        <h3 class="card-title">Manejo de tiempos</h3>
                        <p class="card-text">Revisa las fechas de terminación de tus proyectos para organizar tu tiempo.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card p-4 mb-4">
                        <h3 class="card-title">Manejo de tareas</h3>
                        <p class="card-text">Agrega tareas a tus proyectos para desarrollarlos de una manera más organizada.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="iniciosesion" tabindex="-1" aria-labelledby="iniciosesionLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="iniciosesionLabel">Inicio de sesión</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="loginForm">
                    <div class="mb-3">
                        <label for="loginUser" class="form-label">Usuario</label>
                        <input type="text" class="form-control" id="loginUser" required>
                    </div>
                    <div class="mb-3">
                        <label for="loginPassword" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="loginPassword" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Iniciar Sesión</button>
                </form>
            </div>
        </div>
    </div>
    </div>
    
    <div class="modal fade" id="RegistroModal" tabindex="-1" aria-labelledby="RegistroModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="RegistroModalLabel">Registro</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="registerForm">
                    <div class="mb-3">
                        <label for="registroUsuario" class="form-label">Nombre de Usuario</label>
                        <input type="text" class="form-control" id="registroUsuario" required>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-lg-6">
                            <label for="registroNombre" class="form-label">Nombres</label>
                            <input type="text" class="form-control" id="registroNombre"  required>
                        </div>
                        <div class="col-lg-6">
                            <label for="registroApellido" class="form-label">Apellidos</label>
                            <input type="text" class="form-control" id="registroApellido" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="registroEmail" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control" id="registroEmail" required>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-lg-6">
                            <label for="registroPassword" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="registroPassword" required>
                        </div>                            
                        <div class="col-lg-6">
                            <label for="registroConfirmPassword" class="form-label">Confirmar Contraseña</label>
                            <input type="password" class="form-control" id="registroConfirmPassword"  required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Registrarse</button>
                </form>
            </div>
        </div>
    </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p>&copy; 2025 Gestor de Tareas. Todos los derechos reservados. Desarrollado por Gabriela Ruiz</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <script src="js/jsregistro.js"></script>
    <script src="js/jslogin.js"></script>
</body>
</html>