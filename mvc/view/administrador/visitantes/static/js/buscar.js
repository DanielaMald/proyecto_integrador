function buscarporNombre() {
    const NombreInput = document.getElementById("buscarNombre").value;

    fetch(`http://127.0.0.1:3030/visitantes-buscar/${NombreInput}`, {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        const resultTable = document.getElementById("buscarResult");
        resultTable.innerHTML = "";

        if (data && Object.keys(data).length > 0) {
            const row = resultTable.insertRow();
            row.insertCell().innerHTML = data.nombre;
            row.insertCell().innerHTML = data.appaterno;
            row.insertCell().innerHTML = data.apmaterno;
            row.insertCell().innerHTML = data.motivo;
            row.insertCell().innerHTML = data.dispositivo;
            row.insertCell().innerHTML = data.hora_entrada;
            row.insertCell().innerHTML = data.hora_salida;
            row.insertCell().innerHTML = data.options;

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
        } else {
            const errorMessage = document.createElement("p");
            errorMessage.innerHTML = "Visitante no encontrado.";
            resultTable.appendChild(errorMessage);
        }
    })
    .catch(error => {
        console.error('Error en la solicitud:', error);
    });
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