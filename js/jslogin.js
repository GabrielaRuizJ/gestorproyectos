document.getElementById('loginForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const usuario = document.getElementById('loginUser').value;
    const clave = document.getElementById('loginPassword').value;

    const formData = new FormData();
    formData.append('usuario', usuario);
    formData.append('clave', clave);

    fetch('http://localhost/tareaspruebatecnica/api.php?modulo=usuario&opcion=login', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        console.log(data);
        if (data.success) {
            alert(`¡Bienvenido ${data.usuario.nombre}!`);
            sessionStorage.setItem('usuario', JSON.stringify(data.usuario));
            window.location.href = "vista/home.php";
        } else {
            alert(data.message || 'Credenciales incorrectas');
        }
    })
    .catch(err => {
        console.error('Error en login:', err);
        alert('Error al enviar los datos al servidor');
    });
});
