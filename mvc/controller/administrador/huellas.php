<?php
require "../../model/administrador.php";

$checarModel = new Administrador();
$salones = $checarModel->obtenerTodosLosSalones();
if ($_SERVER["REQUEST_METHOD"] === "GET") {
    // Si la solicitud es GET, simplemente mostramos todos los chequeos
    $resultados = $checarModel->mostrarChequeos();
    if ($resultados !== null) {
        include "../../view/administrador/h.php";
    } else {
        echo "No se encontraron resultados de los checadores.";
    }
} elseif ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Si la solicitud es POST, verificamos si se envió una fecha o un salón
    if (isset($_POST["fecha"])) {
        // Si se proporcionó una fecha, filtramos por esa fecha
        $fecha = $_POST["fecha"];
        $resultados = $checarModel->consultaChequeosPorFecha($fecha);
    } elseif (isset($_POST["salon"])) {
        // Si se proporcionó un salón, filtramos por ese salón
        $salon = $_POST["salon"];
        $resultados = $checarModel->consultaChequeosPorSalon($salon);
    } else {
        // Si no se proporcionó ni fecha ni salón, mostramos todos los chequeos
        $resultados = $checarModel->mostrarChequeos();
    }

    if ($resultados !== null) {
        include "../../view/administrador/h.php";
    } else {
        echo "No se encontraron resultados de los chequeos.";
    }
}
?>
