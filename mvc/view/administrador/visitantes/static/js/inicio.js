async function submitForm(event) {
    event.preventDefault();
    
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;

    try {
        const response = await fetch(`http://127.0.0.1:8000/usuarios/?username=${username}&password=${password}`);
        const data = await response.json();

        if ('token' in data) {
            alert('Tu Token es: ' + data.token);
            
            // Almacenar el token en sessionStorage
            sessionStorage.setItem("token", data.token);
            
            // Redirigir a la página de contactos
            window.location.href = "/contactos";
        } else {
            alert('Error: credenciales inválidas. ' + data.mensaje);
        }
    } catch (error) {
        console.error('Error durante la solicitud:', error);
        alert('Se produjo un error durante el inicio de sesión.');
    }
}
