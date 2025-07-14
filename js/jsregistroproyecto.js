document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('registroFormProyecto').addEventListener('submit', function(e) {
        e.preventDefault(); 
        const p_nombre = document.getElementById('proyectoNombre').value;
        const p_descripcion = document.getElementById('proyectoDescripcion').value;
        const p_fechalimite = document.getElementById('proyectoFechaLimite').value;
        const p_tarifa = document.getElementById('proyectoTarifa').value;
        const p_usuario = document.getElementById('proyectoUsuario').value;

        const formData = new FormData();
        formData.append('nombre_proyecto', p_nombre);
        formData.append('descripcion_proyecto', p_descripcion);
        formData.append('fechalimite_proyecto', p_fechalimite);
        formData.append('tarifa_proyecto', p_tarifa);
        formData.append('usuario_proyecto', p_usuario);

        fetch('http://localhost/tareaspruebatecnica/api.php?modulo=proyecto&opcion=insertar', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            console.log(data);
            if (data.success) {
                alert('¡Registro exitoso!');
                document.getElementById('registroFormProyecto').reset();
                var modal = bootstrap.Modal.getInstance(document.getElementById('crearProyectoModal'));
                modal.hide();
                location.href = location.href;
            } else {
                alert(data.error || data.message || 'Error en el registro');
            }
        })
        .catch(err => {
            console.error('Error al enviar:', err);
            alert('Error al enviar los datos al servidor');
        });
    });


    document.querySelectorAll('.btn-ver-detalles').forEach(boton => {
        boton.addEventListener('click', () => {
            document.getElementById('editarProyectoId').value = boton.dataset.proyectoId;
            document.getElementById('editarNombreProyecto').value = boton.dataset.proyectoNombre;
            document.getElementById('editarDescripcionProyecto').value = boton.dataset.proyectoDescripcion;
            document.getElementById('editarFechaLimiteProyecto').value = boton.dataset.proyectoFechalimite;
            document.getElementById('editarTarifaProyecto').value = boton.dataset.proyectoTarifa;
            document.getElementById('editarEstadoProyecto').value = boton.dataset.proyectoEstado;

            const modal = new bootstrap.Modal(document.getElementById('editarProyectoModal'));
            modal.show();
        });
    });

    document.getElementById('formEditarProyecto').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData();
        formData.append('id_proyecto', document.getElementById('editarProyectoId').value);
        formData.append('nombre_proyecto', document.getElementById('editarNombreProyecto').value);
        formData.append('descripcion_proyecto', document.getElementById('editarDescripcionProyecto').value);
        formData.append('fechalimite_proyecto', document.getElementById('editarFechaLimiteProyecto').value);
        formData.append('tarifa_proyecto', document.getElementById('editarTarifaProyecto').value);
        formData.append('id_estado', document.getElementById('editarEstadoProyecto').value);
        formData.append('usuario_proyecto', document.getElementById('UsuarioID').value); // Oculto

        fetch('http://localhost/tareaspruebatecnica/api.php?modulo=proyecto&opcion=modificar', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            console.log(data);
            if (data.success) {
                alert('Proyecto modificado correctamente.');
                var modal = bootstrap.Modal.getInstance(document.getElementById('editarProyectoModal'));
                modal.hide();
                location.href = location.href;
            } else {
                alert('Error: ' + (data.message || data.error));
            }
        })
        .catch(err => {
            console.error('Error al modificar el proyecto:', err);
            alert('Error inesperado al enviar los datos al servidor.');
        });
    });

});
