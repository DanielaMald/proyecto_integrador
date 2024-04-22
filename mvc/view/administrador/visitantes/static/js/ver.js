document.addEventListener("DOMContentLoaded", function () {
    const params = new URLSearchParams(window.location.search);
    const email = params.get("email");
    var token = sessionStorage.getItem("token");

    // Verificar si el token está presente en sessionStorage
    if (!token) {
        console.error('Token no encontrado en sessionStorage.');
        return;
    }

    fetch(`http://127.0.0.1:8000/contactos/${encodeURIComponent(email)}`, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': 'Bearer ' + token
        }
    })
    .then(response => {
        if (!response.ok) {
            if (response.status === 401) {
                console.error('Token no válido. Se requiere autenticación.');
                alert('Token no válido. Por favor, inicie sesión nuevamente.');
                window.location.href = `/`; // Redirigir a la página de inicio
            }
            throw new Error('Error en la solicitud');
        }
        return response.json();
    })
    .then(data => {
        const contactDetailsDiv = document.getElementById("contact-details");
        contactDetailsDiv.innerHTML = `
            <p>Email: ${data.email}</p>
            <p>Nombre: ${data.nombre}</p>
            <p>Teléfono: ${data.telefono}</p>
        `;
    })
    .catch(error => console.error("Error al obtener detalles del contacto:", error));
});
