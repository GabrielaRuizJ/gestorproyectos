document.addEventListener('DOMContentLoaded', function () {

    function cargarEstadosProyecto() {
        const selectEstado = document.getElementById('editarEstadoProyecto');

        fetch('http://localhost/tareaspruebatecnica/api.php?modulo=estado&opcion=consulta_estados', {
            method: 'POST'
        })
        .then(res => res.json())
        .then(data => {
            if (data.success && Array.isArray(data.message)) {
                selectEstado.innerHTML = '<option value="">Seleccionar estado</option>';
                data.message.forEach(estado => {
                    const option = document.createElement('option');
                    option.value = estado.id_estado;
                    option.textContent = estado.estado;
                    selectEstado.appendChild(option);
                });
            } else {
                console.warn('No se pudo cargar estados.');
            }
        })
        .catch(err => {
            console.error('Error al cargar estados del proyecto:', err);
        });
    }

    function cargarEstadosTarea() {
        const selectEstadoTarea = document.getElementById('editarTareaEstado');

        fetch('http://localhost/tareaspruebatecnica/api.php?modulo=estado&opcion=consulta_estados', {
            method: 'POST'
        })
        .then(res => res.json())
        .then(data => {
            if (data.success && Array.isArray(data.message)) {
                selectEstadoTarea.innerHTML = '<option value="">Selecciona un estado</option>';
                data.message.forEach(estado => {
                    const option = document.createElement('option');
                    option.value = estado.id_estado;
                    option.textContent = estado.estado;
                    selectEstadoTarea.appendChild(option);
                });
            } else {
                console.warn('No se pudieron cargar los estados.');
            }
        })
        .catch(err => {
            console.error('Error al cargar estados:', err);
        });
    }

    cargarEstadosProyecto();
    cargarEstadosTarea();

    const container = document.getElementById('proyectosContainer');
    const idUsuario = document.getElementById('UsuarioID').value;

    const formData = new FormData();
    formData.append('usuario_proyecto', idUsuario);

    fetch('http://localhost/tareaspruebatecnica/api.php?modulo=proyecto&opcion=consulta_proyectos', {
        method: 'POST',
        body: formData
    })
        .then(res => res.json())
        .then(async data => {
            if (data.success && Array.isArray(data.message)) {
                const tarjetasHTML = await Promise.all(data.message.map(async proyecto => {
                    const formTarea = new FormData();
                    formTarea.append('proyecto_id', proyecto.proyecto_id); 

                    let tareasHTML = '';

                    try {
                        const tareasRes = await fetch('http://localhost/tareaspruebatecnica/api.php?modulo=tarea&opcion=consulta_tareas', {
                            method: 'POST',
                            body: formTarea
                        });
                        const tareasData = await tareasRes.json();

                        if (tareasData.success && Array.isArray(tareasData.message)) {
                            tareasData.message.forEach(tarea => {
                            tareasHTML += `
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-1">
                                    ${tarea.nombre_tarea} <span class="badge bg-secondary mt-1">${tarea.estado}</span>
                                    <button 
                                        class="btn btn-sm btn-warning btn-editar-tarea ms-2"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editarTareaModal"
                                        data-tarea-id="${tarea.tarea_id}"
                                        data-tarea-nombre="${tarea.nombre_tarea}"
                                        data-tarea-descripcion="${tarea.descripcion}"
                                        data-tarea-fecha="${tarea.fecha_vencimiento || ''}"
                                        data-tarea-estado="${tarea.estado_id}"><i class="bi bi-pencil-fill"></i>
                                    </button>
                                    <button class="btn btn-danger align-end btn-sm btn-eliminar-tarea"
                                        data-tarea-id="${tarea.tarea_id}"><i class="bi bi-trash3-fill"></i>
                                    </button>
                                </li>
                            `;
                        });
                        } else {
                            tareasHTML += `
                                <li class="list-group-item text-muted">Sin tareas registradas</li>
                            `;
                        }

                    } catch (err) {
                        console.error('Error al obtener tareas del proyecto ' + proyecto.proyecto_id, err);
                        tareasHTML += `<li class="list-group-item text-danger">Error cargando tareas</li>`;
                    }

                    return `
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card card-project h-100">
                                <div class="card-body">
                                    <h5 class="card-title">${proyecto.nombre_proyecto}</h5>
                                    <h6 class="card-subtitle mb-2 text-muted">ID: PROJ-${proyecto.proyecto_id}</h6>
                                    <p class="card-text text-truncate">${proyecto.descripcion}</p>
                                    <ul class="list-group list-group-flush mb-3">
                                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-1">
                                            Fecha Límite: <span class="text-danger">${proyecto.fecha_fin}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-1">
                                            Tarifa: <span class="text-primary">$${Number(proyecto.tarifa).toLocaleString()}</span>
                                        </li>
                                        <li class="list-group-item fw-bold d-flex justify-content-between align-items-center px-0 py-1">Tareas:</li>
                                        ${tareasHTML}
                                    </ul>
                                    <button class="btn btn-info btn-sm w-100 mt-3" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#tareasProyectoModal" 
                                        data-proyecto-id="${proyecto.proyecto_id}"
                                        data-proyecto-nombre="${proyecto.nombre_proyecto}"
                                        data-proyecto-descripcion="${proyecto.descripcion}"
                                        data-proyecto-fechalimite="${proyecto.fecha_fin}"
                                        data-proyecto-tarifa="${proyecto.tarifa}">
                                        Ver/Añadir Tareas
                                    </button>
                                    <a href="#" class="btn btn-outline-primary btn-sm w-100 mt-2 btn-ver-detalles"
                                        data-proyecto-id="${proyecto.proyecto_id}"
                                        data-proyecto-nombre="${proyecto.nombre_proyecto}"
                                        data-proyecto-descripcion="${proyecto.descripcion}"
                                        data-proyecto-fechalimite="${proyecto.fecha_fin}"
                                        data-proyecto-tarifa="${proyecto.tarifa}"
                                        data-proyecto-estado="${proyecto.estado_id}">
                                        Ver Detalles
                                    </a>
                                </div>
                            </div>
                        </div>
                    `;
                }));

                container.innerHTML = tarjetasHTML.join('');

                document.querySelectorAll('.btn-ver-detalles').forEach(boton => {
                    boton.addEventListener('click', function(e) {
                        e.preventDefault();
                        document.getElementById('editarProyectoId').value = this.dataset.proyectoId;
                        document.getElementById('editarNombreProyecto').value = this.dataset.proyectoNombre;
                        document.getElementById('editarDescripcionProyecto').value = this.dataset.proyectoDescripcion;
                        document.getElementById('editarFechaLimiteProyecto').value = this.dataset.proyectoFechalimite;
                        document.getElementById('editarTarifaProyecto').value = this.dataset.proyectoTarifa;
                        document.getElementById('editarEstadoProyecto').value = this.dataset.proyectoEstado;

                        const modal = new bootstrap.Modal(document.getElementById('editarProyectoModal'));
                        modal.show();
                    });
                });

            } else {
                container.innerHTML = `<div class="col-12"><p class="text-center text-muted">No hay proyectos para mostrar.</p></div>`;
            }
        })
        .catch(err => {
            console.error('Error al obtener proyectos:', err);
            container.innerHTML = `<div class="col-12"><p class="text-danger text-center">Error al cargar proyectos.</p></div>`;
        });

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('btn-editar-tarea')) {
            const btn = e.target;

            document.getElementById('editarTareaId').value = btn.dataset.tareaId;
            document.getElementById('editarTareaNombre').value = btn.dataset.tareaNombre;
            document.getElementById('editarTareaDescripcion').value = btn.dataset.tareaDescripcion;
            document.getElementById('editarTareaFecha').value = btn.dataset.tareaFecha;
            setTimeout(() => {
                document.getElementById('editarTareaEstado').value = btn.dataset.tareaEstado;
            }, 100);
        }
    });

    document.getElementById('formEditarTarea').addEventListener('submit', function (e) {
        e.preventDefault();

        const tareaId = document.getElementById('editarTareaId').value;
        const nombre = document.getElementById('editarTareaNombre').value.trim();
        const descripcion = document.getElementById('editarTareaDescripcion').value.trim();
        const fecha = document.getElementById('editarTareaFecha').value;
        const estado = document.getElementById('editarTareaEstado').value;

        if (!nombre || !descripcion || !estado) {
            alert('Completa todos los campos requeridos.');
            return;
        }

        const formData = new FormData();
        formData.append('tarea_id', tareaId);
        formData.append('nombre_tarea', nombre);
        formData.append('descripcion', descripcion);
        formData.append('fecha_vencimiento', fecha);
        formData.append('estado', estado);

        fetch('http://localhost/tareaspruebatecnica/api.php?modulo=tarea&opcion=modificar', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert('Tarea modificada con éxito.');
                const modal = bootstrap.Modal.getInstance(document.getElementById('editarTareaModal'));
                modal.hide();
                location.href = location.href;
            } else {
                alert(data.error || 'Ocurrió un error al modificar la tarea.');
            }
        })
        .catch(err => {
            console.error('Error al modificar tarea:', err);
            alert('Ocurrió un error inesperado.');
        });
    });

    document.addEventListener('click', function(e) {
        const btnEliminar = e.target.closest('.btn-eliminar-tarea');
        if (btnEliminar) {
            const confirmacion = confirm('¿Estás segura/o de que deseas eliminar esta tarea? Esta acción no se puede deshacer.');

            if (!confirmacion) return;

            const tareaId = e.target.dataset.tareaId;

            const formData = new FormData();
            formData.append('tarea_id', tareaId);

            fetch('http://localhost/tareaspruebatecnica/api.php?modulo=tarea&opcion=eliminar', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert('Tarea eliminada con éxito');
                    location.href = location.href;
                } else {
                    alert('No se pudo eliminar la tarea: ' + data.message);
                }
            })
            .catch(err => {
                console.error('Error al eliminar tarea:', err);
                alert('Error inesperado al eliminar la tarea.');
            });
        }
    });

});
