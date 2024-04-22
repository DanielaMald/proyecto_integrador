function insertar() {
    var nombre = document.getElementById('nombre').value;
    var appaterno = document.getElementById('appaterno').value;
    var apmaterno = document.getElementById('apmaterno').value;
    var motivo = document.getElementById('motivo').value;
    var dispositivo = document.getElementById('dispositivo').value;
    
    var request = new XMLHttpRequest();
    request.open('POST', "http://127.0.0.1:3030/visitantes-insertar");
    request.setRequestHeader("Content-Type", "application/json");

    request.onload = function () {
        if (request.status === 200) {
            const response = JSON.parse(request.responseText);
            console.log("Respuesta:", response);
            alert("Visitante insertado correctamente");
            window.location.href = "/";
        } else {
            console.error("Error al hacer la solicitud:", request.status, request.statusText);
            alert("Error al insertar el visitante. Por favor, inténtalo de nuevo.");
        }
    };

    request.onerror = function () {
        console.error("Error de red al intentar hacer la solicitud.");
        alert("Error de red al intentar insertar el visitante. Por favor, inténtalo de nuevo.");
    };

    var data = {
        nombre: nombre,
        appaterno: appaterno,
        apmaterno: apmaterno,
        motivo: motivo,
        dispositivo: dispositivo
    };

    request.send(JSON.stringify(data));
}

function cancelar() {
    window.location.href = "/";
    alert("Acción cancelada");
}
