<?php
// Incluye el archivo del modelo para poder utilizarlo
require "../../model/administrador.php";

// Crea una instancia del modelo
$administradorModel = new Administrador();

// Verifica si se ha enviado el periodo seleccionado desde el cliente
if(isset($_POST['periodo'])) {
    // Obtiene el periodo seleccionado desde la solicitud POST
    $periodoSeleccionado = $_POST['periodo'];
    // Llama al método del modelo para obtener los resultados correspondientes al periodo seleccionado
    $resultados = $administradorModel->buscarGrupoPorPeriodo($periodoSeleccionado);

    // Verifica si se obtuvieron resultados de resultados
    if (!empty($resultados)) {
        // Inicia la construcción de las opciones del campo de selección de grupos
        foreach ($resultados as $grupo) {
            echo "<option value='" . $grupo["nombre"] . "'>" . $grupo["nombre"] . "</option>";
        }
    } else {
        // Si no se encontraron grupos para el periodo seleccionado, muestra un mensaje indicando que no hay grupos disponibles
        echo "<option value='' disabled>No hay grupos disponibles para este periodo</option>";
    }
} else {
    // Si no se proporcionó un periodo, devuelve un mensaje indicando que no se proporcionó un periodo válido
    echo "<option value='' disabled>Selecciona un periodo válido</option>";
}
if(isset($_POST['grupo'])) {
    $grupo = $_POST['grupo'];
    // Filtrar las estudiantes por grupo si se proporciona un valor de grupo
    $estudiantes = $assignmentModel->buscarEstudiantesPorGrupo($grupo);
} else {
    // Si no se proporciona un valor de grupo o período, mostrar todas las estudiantes
    $estudiantes = $assignmentModel->obtenerTodosLosEstudiantes();
}

include "../../view/administrador/m2.php";
?>
