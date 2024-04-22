async function registrarUsuario() {
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;

    const data = {
        username: username,
        password: password
    };

    try {
        const response = await fetch('http://127.0.0.1:8000/usuarios', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        });

        const result = await response.json();

        if ('tu token es' in result) {
            // Almacenar el token en sessionStorage
            sessionStorage.setItem("token", result['tu token es']);

            // Mostrar mensaje de bienvenida
            alert("¡Bienvenido, " + username + "!\nTu token es: " + result['tu token es']);

            // Redirigir a la página de contactos
            window.location.href = "/contactos";
        } else {
            alert('Error al registrar usuario. ' + result.mensaje);
        }

    } catch (error) {
        console.error('Error al registrar usuario:', error);
        alert('Error al registrar usuario. Consulta la consola para más detalles.');
    }
}
