function cerrarSesion() {
    // Limpiar el token almacenado en sessionStorage
    sessionStorage.removeItem("token");
  
    // Redirigir a la página de inicio de sesión u otra página que desees
    window.location.href = "/";
  }