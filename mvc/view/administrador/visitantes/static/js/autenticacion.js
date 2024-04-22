function validarToken(evento) {
  // Evitar que el formulario se envíe de la manera tradicional
  evento.preventDefault();

  // Obtener el token del campo de entrada
  var token = document.getElementById("token").value;

  // Crear un nuevo objeto XMLHttpRequest
  var xhr = new XMLHttpRequest();

  // Configurar la función que manejará los cambios de estado
  xhr.onreadystatechange = function () {
    if (xhr.readyState == 4) {  // Estado "DONE" (completado)
      if (xhr.status == 200) {  // Código de estado 200 (OK)
        // Token válido, almacenar en sessionStorage
        sessionStorage.setItem("token", token);

        // Mostrar mensaje de alerta
        alert("Token válido");

        // Redirigir a la página de contactos
        window.location.href = "/contactos";
      } else {
        // Token inválido, mostrar mensaje de alerta
        alert("Token inválido");
      }
    }
  };

  // Abrir una solicitud GET al punto final validate-token
  xhr.open("GET", "http://127.0.0.1:8000/validate-token", true);

  // Establecer el encabezado "Authorization" con el token Bearer
  xhr.setRequestHeader("Authorization", "Bearer " + token);

  // Enviar la solicitud
  xhr.send();
}
  