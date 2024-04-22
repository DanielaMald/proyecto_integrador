<?php
require "../../model/administrador.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];    
    $correo = $_POST["correo"];
    $contrasena = $_POST["contrasena"];

    // Encriptar la contraseña de manera segura usando password_hash
    $contrasena_encriptada = md5($contrasena);

    // Crear una instancia del modelo AdministradorModel
    $administradorModel = new Administrador();

    // Llamar al método del modelo para guardar los datos del nuevo Admin en la base de datos
    $Admin_guardado = $administradorModel->nuevoAdmin($nombre,$correo, $contrasena_encriptada);

    // Si se guardó correctamente el Admin, redireccionar a una página de éxito
    header("Location:../../view/administrador/admin.html");
    
    
}
?>
