<?php
// Incluir el archivo de conexión a la base de datos
include('conexion.php');

// Verificar si la sesión del profesor está iniciada y obtener su clave
session_start();
if (isset($_SESSION['clave_profesor'])) {
    $clave_profesor = $_SESSION['clave_profesor'];

    // Consulta SQL para obtener las materias asignadas al profesor
    $sql_materias = "SELECT asignaturas.id_asignatura, asignaturas.nombre 
                     FROM asignacionmaterias
                     INNER JOIN asignaturas ON asignacionmaterias.id_asignatura = asignaturas.id_asignatura
                     WHERE asignacionmaterias.clave_profesor = '$clave_profesor'";

    $resultado_materias = $conn->query($sql_materias);

    // Verificar si se obtuvieron resultados
    if ($resultado_materias->num_rows > 0) {
        // Construir las opciones del select
        $opciones_materias = "";
        while ($row = $resultado_materias->fetch_assoc()) {
            $opciones_materias .= "<option value='" . $row['id_asignatura'] . "'>" . $row['nombre'] . "</option>";
        }
        echo $opciones_materias;
    } else {
        // Si no se encontraron materias asignadas al profesor, mostrar un mensaje indicando que no hay opciones disponibles
        echo "<option value=''>No hay materias asignadas</option>";
    }
} else {
    // No se ha iniciado sesión como profesor
    echo "<option value=''>No se ha iniciado sesión como profesor</option>";
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
