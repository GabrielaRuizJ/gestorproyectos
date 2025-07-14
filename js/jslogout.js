document.getElementById('logoutBtn').addEventListener('click', function(e) {
    e.preventDefault();

    fetch('http://localhost/tareaspruebatecnica/api.php?modulo=usuario&opcion=logout', {
        method: 'POST'
    })
    .then(res => res.json())
    .then(data => {
        console.log(data);
        if (data.success) {
            alert('Sesión finalizada');
            sessionStorage.removeItem('usuario');
            window.location.href = '../index.php';
        } else {
            alert('No se pudo cerrar sesión.');
        }
    })
    .catch(err => {
        console.error('Error al cerrar sesión:', err);
        alert('Error al enviar los datos al servidor');
    });
});
