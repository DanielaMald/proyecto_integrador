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
    $resultados = $administradorModel->buscarasignaturasPorPeriodo($periodoSeleccionado);
    if (!empty($resultados)) {
        // Inicia la construcción de las opciones del campo de selección de grupos
        foreach ($resultados as $asignatura) {
            echo "<option value='" . $asignatura["nombre"] . "'>" . $asignatura["nombre"] . "</option>";
        }
    } else {
        // Si no se encontraron grupos para el periodo seleccionado, muestra un mensaje indicando que no hay grupos disponibles
        echo "<option value='' disabled>No hay asignaturas disponibles para este periodo</option>";
    }

}
    // Verifica si se obtuvieron resultados de resultado

?>
