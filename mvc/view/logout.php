<?php
session_start();

// Destruir todas las variables de sesión
session_unset();

// Destruir la sesión
session_destroy();

// Redirigir a la página de inicio de sesión o a cualquier otra página que desees mostrar después del logout
header("Location:../mi_parte/login.php"); // Cambia "index.html" por la página que desees mostrar
exit;
?>
