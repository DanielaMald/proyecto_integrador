document.addEventListener("DOMContentLoaded", function () {
    const params = new URLSearchParams(window.location.search);
    const email = params.get("email");
    var token = sessionStorage.getItem("token");

    if (!token) {
        console.error('Token no encontrado en sessionStorage.');
        return;
    }

    fetch(`http://127.0.0.1:8000/contactos/${encodeURIComponent(email)}`, {
        headers: {
            'Content-Type': 'application/json',
            'Authorization': 'Bearer ' + token
        }
    })
    .then(response => {
        if (response.status === 401) {
            console.error('Token no válido. Se requiere autenticación.');
            alert('Token no válido. Por favor, inicie sesión nuevamente.');
            // Puedes redirigir a la página de inicio de sesión u otra acción apropiada aquí
            return Promise.reject('Token no válido');
        }
        return response.json();
    })
    .then(data => {
        const emailInput = document.getElementById("email");
        const nombreInput = document.getElementById("nombre");
        const telefonoInput = document.getElementById("telefono");

        emailInput.value = data.email;
        nombreInput.value = data.nombre;
        telefonoInput.value = data.telefono;
    })
    .catch(error => console.error("Error al obtener detalles del contacto:", error));
});

function actualizar() {
    const nuevoNombre = document.getElementById("nombre").value;
    const nuevoTelefono = document.getElementById("telefono").value;

    const params = new URLSearchParams(window.location.search);
    const email = params.get("email");

    var token = sessionStorage.getItem("token");

    fetch(`http://127.0.0.1:8000/contactos/${encodeURIComponent(email)}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': 'Bearer ' + token
        },
        body: JSON.stringify({
            email: email,
            nombre: nuevoNombre,
            telefono: nuevoTelefono,
        }),
    })
    .then(response => {
        if (!response.ok) {
            if (response.status === 401) {
                console.error('Token no válido. Se requiere autenticación.');
                alert('Token no válido. Por favor, inicie sesión nuevamente.');
                window.location.href = `/`; // Redirigir a la página de inicio

            }
            return response.json().then(error => {
                throw new Error(`Error al actualizar el contacto. Código de estado: ${response.status}. Detalles: ${JSON.stringify(error)}`);
            });
        }
        return response.json();
    })
    .then(data => {
        const mensajeElemento = document.getElementById("mensaje");
        mensajeElemento.innerHTML = `Contacto actualizado con éxito: ${data.email}, ${data.nombre}, ${data.telefono}`;

        const errorMensajeElemento = document.getElementById("error-mensaje");
        errorMensajeElemento.innerHTML = "";

        window.location.href = "/contactos";
    })
    .catch(error => {
        const errorMensajeElemento = document.getElementById("error-mensaje");
        errorMensajeElemento.innerHTML = `Error al actualizar el contacto: ${error.message}`;

        const mensajeElemento = document.getElementById("mensaje");
        mensajeElemento.innerHTML = "";
    });
}
