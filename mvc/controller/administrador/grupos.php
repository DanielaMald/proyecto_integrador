<?php
require "../../model/administrador.php";

$grupoModel = new Administrador(); // Crear una instancia del modelo

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    // Obtener todos los grupos y periodos para mostrar en la vista
    $resultados = $grupoModel->obtenerTodosLosGrupos();
    $periodos = $grupoModel->obtenerTodosLosPeriodos();

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
        $resultados = $grupoModel->buscarGrupoPorPeriodo($id_periodo);

        // Verificar si $resultados es null y manejar el caso adecuadamente
        if ($resultados !== null) {
            // Obtener todos los periodos para mostrar en la vista
            $periodos = $grupoModel->obtenerTodosLosPeriodos();
            include "../../view/administrador/g2.php"; // Incluir la vista para mostrar resultados de la búsqueda
        } else {
            echo "No se encontraron resultados de los grupos."; // Manejar el caso en que no se encuentren resultados
        }
    } else {
        // Si no se seleccionó un periodo, se muestran todos los grupos
        $resultados = $grupoModel->obtenerTodosLosGrupos();
        $periodos = $grupoModel->obtenerTodosLosPeriodos();
        include "../../view/administrador/g2.php"; // Incluir la vista para mostrar todos los grupos
    }
}
?>
