<?php
require "../../model/administrador.php";

$estudianteModel = new Administrador(); // Crear una instancia del modelo

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $resultados = $estudianteModel->obtenerTodosLosProfesores();
    include "../../view/administrador/p2.php"; // Incluir la vista para mostrar todos los estudiantes
} elseif ($_SERVER["REQUEST_METHOD"] === "POST") {
    $clave_profesor = $_POST["clave_profesor"];
    $resultados = $estudianteModel->buscarProfesorPorClave($clave_profesor);
    include "../../view/administrador/p2.php"; // Incluir la vista para mostrar resultados de la búsqueda
}
?>
