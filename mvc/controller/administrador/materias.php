<?php
require "../../model/administrador.php";

$asignaturasModel = new Administrador(); // Crear una instancia del modelo

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    // Obtener todos los grupos y periodos para mostrar en la vista
    $resultados = $asignaturasModel->obtenerTodosLosasignaturas();
    $periodos = $asignaturasModel->obtenerTodosLosPeriodos();

    // Verificar si $resultados es null y manejar el caso adecuadamente
    if ($resultados !== null) {
        include "../../view/administrador/g2.php"; // Incluir la vista para mostrar todos los grupos
    } else {
        echo "No se encontraron resultados de los grupos."; // Manejar el caso en que no se encuentren resultados
    }
} elseif ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Verificar si se ha enviado un periodo para buscar
    if (isset($_POST["periodo"])) {
        $id_periodo = $_POST["periodo"];
        // Obtener los grupos filtrados por el periodo seleccionado
        $resultados = $asignaturasModel->buscarasignaturasPorPeriodo($id_periodo);

        // Verificar si $resultados es null y manejar el caso adecuadamente
        if ($resultados !== null) {
            // Obtener todos los periodos para mostrar en la vista
            $periodos = $asignaturasModel->obtenerTodosLosPeriodos();
            include "../../view/administrador/mat2.php"; // Incluir la vista para mostrar resultados de la búsqueda
        } else {
            echo "No se encontraron resultados de los asignaturass."; // Manejar el caso en que no se encuentren resultados
        }
    } else {
        // Si no se seleccionó un periodo, se muestran todos los grupos
        $resultados = $asignaturasModel->obtenerTodosLosasignaturas();
        $periodos = $asignaturasModel->obtenerTodosLosPeriodos();
        include "../../view/administrador/mat2.php"; // Incluir la vista para mostrar todos los grupos
    }
}
?>
