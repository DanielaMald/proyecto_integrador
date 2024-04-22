<?php
include "../../model/administrador.php";

$assignmentModel = new Administrador();

$periodos = $assignmentModel->obtenerTodosLosPeriodos();

if(isset($_POST['grupo'])) {
    $grupo = $_POST['grupo'];
    $asignaciones = $assignmentModel->MostrarAsignacionesPorGrupo($grupo);
} else {
    $asignaciones = $assignmentModel->MostrarAsignaciones();
}

include "../../view/administrador/asig2.php";
?>
