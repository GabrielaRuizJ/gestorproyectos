
document.getElementById('registerForm').addEventListener('submit', function(e) {
    e.preventDefault(); 
    const usuario = document.getElementById('registroUsuario').value;
    const nombre = document.getElementById('registroNombre').value;
    const apellido = document.getElementById('registroApellido').value;
    const email = document.getElementById('registroEmail').value;
    const clave = document.getElementById('registroPassword').value;
    const confirmar = document.getElementById('registroConfirmPassword').value;

    if (clave !== confirmar) {
        alert('Las contraseñas no coinciden');
        return;
    }

    const formData = new FormData();
    formData.append('opcion', 'insertar');
    formData.append('usuario', usuario);
    formData.append('nombre', nombre);
    formData.append('apellido', apellido);
    formData.append('email', email);
    formData.append('clave', clave);

    fetch('http://localhost/tareaspruebatecnica/api.php?modulo=usuario&opcion=insertar', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        console.log(data);
        if (data.success) {
            alert('¡Registro exitoso!');
            document.getElementById('registerForm').reset();
            var modal = bootstrap.Modal.getInstance(document.getElementById('RegistroModal'));
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
