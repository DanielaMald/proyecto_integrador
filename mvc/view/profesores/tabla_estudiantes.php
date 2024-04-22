<?php
// Conexión a la base de datos (reemplaza con tus propios datos)
include "../../controller/administrador/conexion.php";

// Consulta para obtener la lista de estudiantes
$sql = "SELECT * FROM estudiantes";
$resultado = $conexion->query($sql);

// Mostrar la tabla de estudiantes en una tabla HTML
if ($resultado->num_rows > 0) {
    echo "<h2>Lista de Estudiantes</h2>";
    echo "<table border='1'>";
    echo "<tr><th>Matrícula</th><th>Nombre</th><th>Ver Asistencia</th></tr>";
    while ($fila = $resultado->fetch_assoc()) {
        echo "<tr><td>" . $fila["matricula"] . "</td><td>" . $fila["nombre"] . "</td><td><a href='historial_asistencia.php?matricula=" . $fila["matricula"] . "'>Ver Historial de Asistencia</a></td></tr>";
    }
    echo "</table>";
} else {
    echo "No se encontraron estudiantes.";
}

// Cerrar la conexión a la base de datos
$conexion->close();
?>
