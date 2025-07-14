<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    // Si no hay sesión activa, redirige al index o login
    header("Location: ../index.php");
    exit();
}else{
    $usuario = $_SESSION['usuario'];
}
?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard de Proyectos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f0f2f5; 
        }
        .navbar-brand {
            font-weight: bold;
        }
        .header-section {
            padding: 40px 0;
            background-color: #ffffff;
            border-bottom: 1px solid #e0e0e0;
            margin-bottom: 30px;
        }
        .card-project {
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
            border: 1px solid #e9ecef;
            border-radius: .5rem;
            height: 100%;
        }
        .card-project:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0,0,0,.1);
        }
        .card-title {
            color: #007bff;
        }
        .progress-bar {
            background-color: #28a745; 
        }
        .placeholder-glow {
            animation: placeholder-animation 1.5s infinite;
        }

        @keyframes placeholder-animation {
            0% { background-position: -468px 0; }
            100% { background-position: 468px 0; }
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Gestor de Proyectos</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Mis Proyectos</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <input type="hidden" id="UsuarioID" value="<?php echo  $usuario['id_usuario']; ?>">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-fill rounded-circle me-1"></i>  Usuario
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#"><i class="bi bi-person-fill rounded-circle me-1"></i> <?php echo  $usuario['nombre'] .' '. $usuario['apellido']; ?></a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#" id="perfilview">Perfil</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#" id="logoutBtn">Cerrar Sesión</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <header class="header-section">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="mb-0">Dashboard de Proyectos</h1>
                    <p class="lead text-muted">Aquí tienes un resumen de tus proyectos activos.</p>
                </div>
                <button class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#crearProyectoModal">
                    <i class="bi bi-plus-lg me-2"></i> Nuevo Proyecto
                </button>
            </div>
        </div>
    </header>

    <main class="container mb-5">
        <div class="row" id="proyectosContainer">            
        </div>
        <div class="row">
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card card-project d-flex align-items-center justify-content-center text-center h-100 border-dashed" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#crearProyectoModal">
                    <div class="card-body">
                        <i class="bi bi-plus-circle display-4 text-muted mb-3"></i>
                        <h5 class="card-title text-muted">Crear Nuevo Proyecto</h5>
                        <p class="card-text text-muted">Haz clic para iniciar un nuevo proyecto.</p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <div class="modal fade" id="crearProyectoModal" tabindex="-1" aria-labelledby="crearProyectoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="crearProyectoModalLabel">Crear Nuevo Proyecto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="registroFormProyecto">
                        <div class="mb-3">
                            <input type="hidden" class="form-control" id="proyectoUsuario" value="<?php echo  $usuario['id_usuario']; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="proyectoNombre" class="form-label">Nombre del Proyecto</label>
                            <input type="text" class="form-control" id="proyectoNombre" required value="Prueba proyecto">
                        </div>
                        <div class="mb-3">
                            <label for="proyectoDescripcion" class="form-label">Descripción</label>
                            <textarea class="form-control" id="proyectoDescripcion" rows="3" required value="Proyecto descripcion"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="proyectoFechaLimite" class="form-label">Fecha Límite</label>
                            <input type="date" class="form-control" id="proyectoFechaLimite" required value="30/07/2025">
                        </div>
                        <div class="mb-3">
                            <label for="proyectoTarifa" class="form-label">Tarifa</label>
                            <input type="number" class="form-control" id="proyectoTarifa" required value="1500000">
                        </div>
                        <button type="submit" class="btn btn-success w-100">Crear Proyecto</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="tareasProyectoModal" tabindex="-1" aria-labelledby="tareasProyectoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tareasProyectoModalLabel">Tareas del Proyecto: <span id="nombreProyectoModal"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <strong>Descripción:</strong> <span id="descripcionProyectoModal"></span><br>
                        <strong>Fecha Límite:</strong> <span id="fechaLimiteProyectoModal"></span><br>
                        <strong>Tarifa:</strong> <span id="tarifaProyectoModal"></span>
                    </div>

                    <hr>

                    <h5>Lista de Tareas</h5>
                    <ul class="list-group mb-4" id="listaTareas">
                        <li class="list-group-item text-muted" id="noTasksMessage">No hay tareas para este proyecto aún.</li>
                    </ul>

                    <hr>

                    <h5>Agregar Nueva Tarea</h5>
                    <form id="formAgregarTarea">
                        <input type="hidden" id="tareaProyectoId">

                        <div class="mb-3">
                            <label for="tareaNombre" class="form-label">Nombre de la Tarea</label>
                            <input type="text" class="form-control" id="tareaNombre" placeholder="Escribe el nombre de la tarea" required>
                        </div>

                        <div class="mb-3">
                            <label for="tareaEstado" class="form-label">Estado de la Tarea</label>
                            <select id="tareaEstado" class="form-select" required>
                                <option disabled selected value="">Seleccionar estado</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="tareaDescripcion" class="form-label">Descripción de la Tarea</label>
                            <input type="text" class="form-control" id="tareaDescripcion" placeholder="Escribe la descripción de la tarea" required>
                        </div>

                        <div class="mb-3">
                            <label for="tareaFechaLimite" class="form-label">Fecha Límite (Opcional)</label>
                            <input type="date" class="form-control" id="tareaFechaLimite">
                        </div>

                        <button type="submit" class="btn btn-success w-100">
                            <i class="bi bi-plus-lg me-2"></i> Añadir Tarea
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editarProyectoModal" tabindex="-1" aria-labelledby="editarProyectoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="formEditarProyecto">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editarProyectoModalLabel">Editar Proyecto</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="editarProyectoId" name="id_proyecto">
                        <input type="hidden" id="editarUsuarioId" name="usuario_proyecto" value="<?php echo $usuario['id_usuario']; ?>">

                        <div class="mb-3">
                            <label for="editarNombreProyecto" class="form-label">Nombre del Proyecto</label>
                            <input type="text" class="form-control" id="editarNombreProyecto" name="nombre_proyecto" required>
                        </div>
                        <div class="mb-3">
                            <label for="editarDescripcionProyecto" class="form-label">Descripción</label>
                            <textarea class="form-control" id="editarDescripcionProyecto" name="descripcion_proyecto" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="editarFechaLimiteProyecto" class="form-label">Fecha Límite</label>
                            <input type="date" class="form-control" id="editarFechaLimiteProyecto" name="fechalimite_proyecto" required>
                        </div>
                        <div class="mb-3">
                            <label for="editarTarifaProyecto" class="form-label">Tarifa</label>
                            <input type="number" class="form-control" id="editarTarifaProyecto" name="tarifa_proyecto" required>
                        </div>
                        <div class="mb-3">
                            <label for="editarEstadoProyecto" class="form-label">Estado</label>
                            <select class="form-select" id="editarEstadoProyecto" name="id_estado" required>
                                <option value="">Seleccionar estado</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Guardar Cambios</button>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editarTareaModal" tabindex="-1">
        <div class="modal-dialog">
            <form id="formEditarTarea" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Tarea</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="editarTareaId">
                    <div class="mb-2">
                        <label for="editarTareaNombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="editarTareaNombre" required>
                    </div>
                    <div class="mb-2">
                        <label for="editarTareaDescripcion" class="form-label">Descripción</label>
                        <textarea class="form-control" id="editarTareaDescripcion" required></textarea>
                    </div>
                    <div class="mb-2">
                        <label for="editarTareaFecha" class="form-label">Fecha límite</label>
                        <input type="date" class="form-control" id="editarTareaFecha">
                    </div>
                    <div class="mb-2">
                        <label for="editarTareaEstado" class="form-label">Estado</label>
                        <select class="form-control" id="editarTareaEstado"></select>
                    </div>
                    <button type="submit" class="btn btn-success">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="perfilModal" tabindex="-1" aria-labelledby="perfilModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <form id="perfilForm">
            <div class="modal-header">
            <h5 class="modal-title" id="perfilModalLabel">Mi Perfil</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
            <input type="hidden" id="perfilUsuarioId">
            <div class="mb-3">
                <label for="perfilUsuario" class="form-label">Usuario</label>
                <input type="text" class="form-control" id="perfilUsuario" required>
            </div>
            <div class="mb-3">
                <label for="perfilNombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="perfilNombre" required>
            </div>
            <div class="mb-3">
                <label for="perfilApellido" class="form-label">Apellido</label>
                <input type="text" class="form-control" id="perfilApellido" required>
            </div>
            <div class="mb-3">
                <label for="perfilEmail" class="form-label">Email</label>
                <input type="email" class="form-control" id="perfilEmail" required>
            </div>
            </div>
            <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            </div>
        </form>
        </div>
    </div>
    </div>



    <footer class="footer bg-dark text-white py-3 mt-auto">
        <div class="container text-center">
            <p>&copy; 2025 Gestor de Tareas. Todos los derechos reservados. Desarrollado por Gabriela Ruiz</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <script src="../js/jsregistroproyecto.js"></script>
    <script src="../js/jslistarproyectos.js"></script>
    <script src="../js/jsgestiontareas.js"></script>
    <script src="../js/jslogout.js"></script>
    <script src="../js/jsperfil.js"></script>

</body>
</html>