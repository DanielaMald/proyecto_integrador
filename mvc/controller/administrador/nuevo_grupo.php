<?php
require "../../model/administrador.php";
$administradorModel = new Administrador();

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $resultado_periodos = $administradorModel->obtenerPeriodos();
    include "../../view/administrador/nuevo_grupo2.php"; 
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $periodo = $_POST["periodo"];
    
    $id_periodo = $administradorModel->obtenerIdPeriodo($periodo); // Asumiendo que esta función existe en el modelo Administrador
    $grupo_guardado = $administradorModel->nuevoGrupo($nombre, $id_periodo);

    // Redirigir después de guardar el grupo
    header("Location:../../view/administrador/admin.html");
    exit(); // Asegura que no se procese más código después de la redirección
}
?>