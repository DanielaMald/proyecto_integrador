<?php

include "../../model/administrador.php";

$asignacionesModel = new Administrador();

$resultado_profesores = $asignacionesModel->obtenerProfesores();
$periodos = $asignacionesModel->obtenerTodosLosPeriodos();
include "../../view/administrador/nueva_asignacion2.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $asignatura_nombre = $_POST["asignatura"];
    $grupo = $_POST["grupo"];
    $profesor_nombre = $_POST["profesor"];
    $periodo = $_POST["periodo"];

    $id_asignatura = $asignacionesModel->obtenerIdAsignatura($asignatura_nombre);
    $id_profesor = $asignacionesModel->obtenerIdProfesor($profesor_nombre);
    $id_grupo = $asignacionesModel->obtenerIdGrupo($grupo);

    if ($id_asignatura && $id_profesor && $id_grupo && $periodo) {
        if ($asignacionesModel->insertarAsignacion($id_asignatura, $id_profesor, $id_grupo, $periodo)) {
            echo "Registro exitoso.";
        } else {
            echo "Error al registrar la asignación de materia.";
        }
    } else {
        echo "Error: No se pudo obtener información necesaria para la asignación.";
    }
}



?>
