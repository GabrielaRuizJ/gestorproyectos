document.addEventListener('DOMContentLoaded', () => {
    const perfilLink =  document.getElementById('perfilview'); 

    if (perfilLink) {
        perfilLink.addEventListener('click', function (e) {
            e.preventDefault();

            const id = document.getElementById('UsuarioID').value;

            const formData = new FormData();
            formData.append('id_usuario', id);

            fetch('http://localhost/tareaspruebatecnica/api.php?modulo=usuario&opcion=consulta_usuario', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success && data.usuario) {
                    const usuario = data.usuario;

                    document.getElementById('perfilUsuarioId').value = usuario.id_usuario;
                    document.getElementById('perfilUsuario').value = usuario.usuario;
                    document.getElementById('perfilNombre').value = usuario.nombre;
                    document.getElementById('perfilApellido').value = usuario.apellido;
                    document.getElementById('perfilEmail').value = usuario.email;

                    const modal = new bootstrap.Modal(document.getElementById('perfilModal'));
                    modal.show();
                } else {
                    alert('No se pudo cargar la información del perfil');
                }
            })
            .catch(error => {
                console.error('Error al consultar el perfil del usuario:', error);
                alert('Ocurrió un error al cargar los datos del perfil');
            });
        });
    }

    document.getElementById('perfilForm').addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData();
        formData.append('id_usuario', document.getElementById('perfilUsuarioId').value);
        formData.append('usuario', document.getElementById('perfilUsuario').value);
        formData.append('nombre', document.getElementById('perfilNombre').value);
        formData.append('apellido', document.getElementById('perfilApellido').value);
        formData.append('email', document.getElementById('perfilEmail').value);

        fetch('http://localhost/tareaspruebatecnica/api.php?modulo=usuario&opcion=modificar', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert('Perfil actualizado correctamente');
                bootstrap.Modal.getInstance(document.getElementById('perfilModal')).hide();
                location.reload();
            } else {
                alert(data.message || 'No se pudo actualizar el perfil');
            }
        })
        .catch(err => {
            console.error('Error al actualizar perfil:', err);
            alert('Error inesperado al actualizar perfil');
        });
    });
});
