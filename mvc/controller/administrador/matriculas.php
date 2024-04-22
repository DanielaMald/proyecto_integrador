<?php
require "../../model/administrador.php";

$estudianteModel = new Administrador(); // Crear una instancia del modelo
$periodos = $estudianteModel->obtenerTodosLosPeriodos();

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $resultados = $estudianteModel->obtenerTodosLosEstudiantes();
    include "../../view/administrador/m2.php"; // Incluir la vista para mostrar todos los estudiantes
} elseif (isset($_POST['grupo'])) {
    $grupo = $_POST["grupo"];
    $resultados = $estudianteModel->buscarEstudiantesPorGrupo($grupo);
    include "../../view/administrador/m2.php"; // Incluir la vista para mostrar resultados de la búsqueda
}
?>
