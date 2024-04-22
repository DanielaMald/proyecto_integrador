<?php
require "../../model/administrador.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $clave_profesor = $_POST["clave"];
    $nombre = $_POST["nombre"];
    $apellido1 = $_POST["ap_paterno"];
    $apellido2 = $_POST["ap_materno"];
    $correo = $_POST["correo"];
    $contrasena = $_POST["contrasena"];

    // Encriptar la contraseña de manera segura usando password_hash
    $contrasena_encriptada = md5($contrasena);

    // Crear una instancia del modelo AdministradorModel
    $administradorModel = new Administrador();

    // Llamar al método del modelo para guardar los datos del nuevo profesor en la base de datos
    $profesor_guardado = $administradorModel->nuevoProfesor($clave_profesor, $nombre, $apellido1, $apellido2, $correo, $contrasena_encriptada);

    // Si se guardó correctamente el profesor, redireccionar a una página de éxito

    header("Location:../../view/administrador/admin.html");       

}
?>
