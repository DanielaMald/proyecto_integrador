function getAll() {
    var request = new XMLHttpRequest();
    var url = "http://127.0.0.1:3030/visitantes";
    request.open('GET', url);
    request.setRequestHeader('Accept', 'application/json');

    request.onreadystatechange = function () {
        if (request.readyState === XMLHttpRequest.DONE) {
            if (request.status === 200) {
                const response = JSON.parse(request.responseText);
                console.log("response: " + JSON.stringify(response));
                const tbody_visitantes = document.getElementById("tbody_visitantes");
                tbody_visitantes.innerHTML = "";

                response.forEach((visitante) => {
                    var tr = document.createElement("tr");
                    var td_nombre = document.createElement("td");
                    var td_appaterno = document.createElement("td");
                    var td_apmaterno = document.createElement("td");
                    var td_motivo = document.createElement("td");
                    var td_dispositivo = document.createElement("td");
                    var td_hora_entrada = document.createElement("td");
                    var td_hora_salida = document.createElement("td"); // Agregado para los botones
                    var td_options = document.createElement("td"); // Agregado para los botones

                    td_nombre.innerHTML = visitante["nombre"];
                    td_appaterno.innerHTML = visitante["appaterno"];
                    td_apmaterno.innerHTML = visitante["apmaterno"];
                    td_motivo.innerHTML = visitante["motivo"];
                    td_dispositivo.innerHTML = visitante["dispositivo"];
                    td_hora_entrada.innerHTML = visitante["hora_entrada"];
                    td_hora_salida.innerHTML = visitante["hora_salida"]; // Agregado para los botones

                    

                    var salidaButton = document.createElement("button");
                    salidaButton.textContent = "salida";
                    salidaButton.addEventListener("click", function () {
                        var nombre = `${visitante["nombre"]} ${visitante["appaterno"]} ${visitante["apmaterno"]}`;
                        var visitanteId = visitante["_id"];
                        actualizarSalida(visitanteId, nombre);
                    });

                    var eliminarButton = document.createElement("button");
                    eliminarButton.textContent = "Borrar";
                    eliminarButton.addEventListener("click", function () {
                        var nombre = `${visitante["nombre"]} ${visitante["appaterno"]} ${visitante["apmaterno"]}`;
                        eliminarVisitante(visitante["_id"], nombre);
                    });


                    td_options.appendChild(salidaButton);
                    td_options.appendChild(eliminarButton);

                    tr.appendChild(td_nombre);
                    tr.appendChild(td_appaterno);
                    tr.appendChild(td_apmaterno);
                    tr.appendChild(td_motivo);
                    tr.appendChild(td_dispositivo);
                    tr.appendChild(td_hora_entrada);
                    tr.appendChild(td_hora_salida); // Agregado para los botones
                    tr.appendChild(td_options); // Agregado para los botones
                    

                    tbody_visitantes.appendChild(tr);
                });
            } else if (request.status === 401) {
                console.error('Token no válido. Se requiere autenticación.');
                alert('Token no válido. Por favor, inicie sesión nuevamente.');
                window.location.href = `/`; // Redirigir a la página de inicio

            } else {
                console.error('Error HTTP al intentar realizar la solicitud. Código de estado:', request.status);
                alert('Error al cargar los visitantes. Por favor, inténtelo de nuevo más tarde.');
                // Podrías mostrar un mensaje de error al usuario o realizar otras acciones
            }
        }
    };

    request.send();
}
function cerrarSesion() {
    window.location.href = `https://localhost/efi1002/mvc/view/administrador/admin.html`; // Redirigir a la página de inicio
}
function actualizarSalida(visitanteId, nombre) {
    const confirmacion = confirm(`¿Estás seguro de que deseas dar salida a ${nombre}?`);
    if (!confirmacion) return; 

    const url = `http://127.0.0.1:3030/visitantes-actualizar/${visitanteId}`;
    const data = { hora_salida: new Date().toISOString() }; // Obtener la hora actual como la nueva hora de salida
    const options = {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    };

    fetch(url, options)
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al actualizar la salida del visitante');
            }
            return response.json();
        })
        .then(data => {
            console.log('Salida del visitante actualizada correctamente:', data);
            // Aquí puedes agregar cualquier lógica adicional que desees, como actualizar la interfaz de usuario, mostrar un mensaje de éxito, etc.
            alert(`Salida del visitante ${nombre} actualizada correctamente`);
            location.reload(); // Recargar la página después de actualizar la salida
        })
        .catch(error => {
            console.error('Error al actualizar la salida del visitante:', error);
            // Aquí puedes manejar el error, por ejemplo, mostrando un mensaje de error al usuario
        });
}
function eliminarVisitante(visitanteId, nombre) {
    const confirmacion = confirm(`¿Estás seguro de que deseas eliminar a ${nombre}?`);
    if (!confirmacion) return; // Si el usuario cancela, no hacer nada

    const url = `http://127.0.0.1:3030/visitantes-eliminar/${visitanteId}`;
    const options = {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json'
        }
    };

    fetch(url, options)
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al eliminar el visitante');
            }
            return response.json();
        })
        .then(data => {
            console.log('Visitante eliminado correctamente:', data);
            location.reload(); // Recargar la página después de eliminar el visitante
            // Aquí puedes agregar cualquier lógica adicional que desees, como actualizar la interfaz de usuario, mostrar un mensaje de éxito, etc.
        })
        .catch(error => {
            console.error('Error al eliminar el visitante:', error);
            // Aquí puedes manejar el error, por ejemplo, mostrando un mensaje de error al usuario
        });
}
function gps() {
    window.location.href = `http://192.168.137.244`; // Redirigir a la página de inicio
}