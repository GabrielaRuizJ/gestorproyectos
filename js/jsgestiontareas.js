document.addEventListener('DOMContentLoaded', function () {
    const tareasProyectoModal = document.getElementById('tareasProyectoModal');
    const tareaProyectoIdInput = document.getElementById('tareaProyectoId');
    const nombreProyectoModalSpan = document.getElementById('nombreProyectoModal');
    const descripcionProyectoModalSpan = document.getElementById('descripcionProyectoModal');
    const fechaLimiteProyectoModalSpan = document.getElementById('fechaLimiteProyectoModal');
    const tarifaProyectoModalSpan = document.getElementById('tarifaProyectoModal');
    const listaTareasUl = document.getElementById('listaTareas');
    const noTasksMessage = document.getElementById('noTasksMessage');
    const selectEstadoTarea = document.getElementById('tareaEstado');


    fetch(`http://localhost/tareaspruebatecnica/api.php?modulo=estado&opcion=consulta_estados`, {
        method: 'POST'
    })
        .then(res => res.json())
        .then(data => {
            if (data.success && Array.isArray(data.message)) {
                data.message.forEach(estado => {
                    const option = document.createElement('option');
                    option.value = estado.id_estado;
                    option.textContent = estado.estado;
                    selectEstadoTarea.appendChild(option);
                });
            }
        })
        .catch(err => {
            console.error('Error al cargar estados:', err);
        });

    tareasProyectoModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const idProyecto = button.getAttribute('data-proyecto-id');
        const nombreProyecto = button.getAttribute('data-proyecto-nombre');
        const descripcionProyecto = button.getAttribute('data-proyecto-descripcion');
        const fechaLimiteProyecto = button.getAttribute('data-proyecto-fechalimite');
        const tarifaProyecto = button.getAttribute('data-proyecto-tarifa');

        nombreProyectoModalSpan.textContent = nombreProyecto;
        descripcionProyectoModalSpan.textContent = descripcionProyecto;
        fechaLimiteProyectoModalSpan.textContent = fechaLimiteProyecto;
        tarifaProyectoModalSpan.textContent = `$${parseFloat(tarifaProyecto).toLocaleString()}`;
        tareaProyectoIdInput.value = idProyecto;

        listaTareasUl.innerHTML = '';
        noTasksMessage.style.display = 'block';

        const formData = new FormData();
        formData.append('proyecto_id', idProyecto);
        fetch(`http://localhost/tareaspruebatecnica/api.php?modulo=tarea&opcion=consulta_tareas`, {
            method: 'POST',
            body: formData
        })
            .then(res => res.json())
            .then(data => {
                if (data.success && Array.isArray(data.message) && data.message.length > 0) {
                    noTasksMessage.style.display = 'none';
                    data.message.forEach(tarea => {
                        const item = document.createElement('li');
                        item.className = 'list-group-item';
                        item.innerHTML = `
                            <strong>${tarea.nombre_tarea}</strong><br>
                            <span class="text-muted">${tarea.descripcion}</span><br>
                            <small>Fecha límite: ${tarea.fecha_vencimiento || 'No asignada'}</small><br>
                            <span class="badge bg-secondary mt-1">${tarea.estado}</span>
                        `;
                        listaTareasUl.appendChild(item);
                    });
                }
            })
            .catch(err => {
                console.error('Error al obtener tareas del proyecto:', err);
            });
    });

    const formAgregarTarea = document.getElementById('formAgregarTarea');
    const tareaNombreInput = document.getElementById('tareaNombre');
    const tareaDescripcionInput = document.getElementById('tareaDescripcion');
    const tareaFechaLimiteInput = document.getElementById('tareaFechaLimite');
    const tareaEstadoSelect = document.getElementById('tareaEstado');
    const idUsuario = document.getElementById('UsuarioID').value;

    formAgregarTarea.addEventListener('submit', function (e) {
        e.preventDefault();

        const nombreTarea = tareaNombreInput.value.trim();
        const descripcionTarea = tareaDescripcionInput.value.trim();
        const fechaVencimiento = tareaFechaLimiteInput.value;
        const estadoId = tareaEstadoSelect.value;
        const proyectoId = tareaProyectoIdInput.value;

        if (!nombreTarea || !descripcionTarea || !estadoId) {
            alert('Por favor completa todos los campos requeridos.');
            return;
        }

        const formData = new FormData();
        formData.append('proyecto_id', proyectoId);
        formData.append('usuario_id', idUsuario);
        formData.append('nombre_tarea', nombreTarea);
        formData.append('descripcion', descripcionTarea);
        formData.append('fecha_vencimiento', fechaVencimiento);
        formData.append('estado', estadoId);

        fetch('http://localhost/tareaspruebatecnica/api.php?modulo=tarea&opcion=insertar', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert('Tarea registrada correctamente.');
                formAgregarTarea.reset();
                tareasProyectoModal.dispatchEvent(new CustomEvent('show.bs.modal', {
                    detail: { relatedTarget: document.querySelector(`[data-proyecto-id="${proyectoId}"]`) }
                }));
            } else {
                alert('Error al registrar tarea: ' + data.error);
            }
        })
        .catch(err => {
            console.error('Error al registrar la tarea:', err);
            alert('Ocurrió un error inesperado al registrar la tarea.');
        });
    });



});
