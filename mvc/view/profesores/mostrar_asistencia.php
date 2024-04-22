<?php
// Conexión a la base de datos (reemplaza con tus propios datos)
include "../../controller/administrador/conexion.php";

// Consulta para obtener la asistencia de los alumnos
$sql = "SELECT * FROM asistencia_alumno";
$resultado = $conexion->query($sql);

// Mostrar la asistencia en una tabla HTML
if ($resultado->num_rows > 0) {
    echo "<table border='1'>";
    echo "<tr><th>ID Asistencia</th><th>Fecha</th><th>Hora de Entrada</th><th>Hora de Salida</th><th>Matrícula del Alumno</th><th>Asistencia</th></tr>";
    while ($fila = $resultado->fetch_assoc()) {
        echo "<tr><td>" . $fila["id_asistencia"] . "</td><td>" . $fila["fecha"] . "</td><td>" . $fila["hora_entrada"] . "</td><td>" . $fila["hora_salida"] . "</td><td>" . (isset($fila["matricula"]) ? $fila["matricula"] : "N/A") . "</td><td>" . ($fila["asistencia"] ? "Presente" : "Ausente") . "</td></tr>";
    }
    echo "</table>";
} else {
    echo "No se encontraron registros de asistencia.";
}

// Cerrar la conexión a la base de datos
$conexion->close();
?>
