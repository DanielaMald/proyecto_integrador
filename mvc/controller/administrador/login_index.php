<?php
session_start();

// Incluir el modelo Administrador
require "../../model/administrador.php";

// Verificar si se envió un formulario de inicio de sesión
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];

    // Crear una instancia del modelo Administrador
    $administrador = new Administrador();

    // Validar las credenciales utilizando el modelo
    if ($administrador->validarCredenciales($correo, $contrasena)) {
        // Las credenciales son válidas, iniciar sesión y redirigir al usuario
        $_SESSION['correo'] = $correo;
        $_SESSION['loggedin'] = true;

        // Redirigir al usuario a la página adecuada
        header('Location: ../../view/administrador/admin.html');
        exit;
    } else {
        // Las credenciales son inválidas, mostrar un mensaje de error
        $error = "Credenciales inválidas";
    }
}

// Redirigir de vuelta al formulario de inicio de sesión con el posible error
header('Location: ../../view/administrador/login_index.php?error=' . urlencode($error));
exit;
?>
