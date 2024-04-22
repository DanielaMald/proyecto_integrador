<?php
// Incluir la conexión a la base de datos
include('conexion.php');

// Verificar si se recibió el parámetro 'id_grupo' enviado por GET
if (isset($_GET['id_grupo'])) {
    $grupoSeleccionado = $_GET['id_grupo'];

    // Consulta SQL para obtener los alumnos del grupo seleccionado
    $sql_alumnos = "SELECT matricula, nombre, apellido1, apellido2 FROM estudiantes_inscritos WHERE id_grupo = $grupoSeleccionado";
    $resultado_alumnos = $conn->query($sql_alumnos);

    // Verificar si se encontraron alumnos
    if ($resultado_alumnos->num_rows > 0) {
        // Construir las opciones de los alumnos
        $opciones = '';
        while ($row_alumno = $resultado_alumnos->fetch_assoc()) {
            $nombre_completo = $row_alumno['nombre'] . ' ' . $row_alumno['apellido1'] . ' ' . $row_alumno['apellido2'];
            $matricula = $row_alumno['matricula']; // Obtener la matrícula del alumno
            // Agregar la opción con el atributo data-matricula
            $opciones .= "<option value='$matricula' data-matricula='$matricula'>$nombre_completo</option>";
        }
        echo $opciones;
    } else {
        echo "<option value=''>No se encontraron alumnos para este grupo.</option>";
    }
} else {
    echo "<option value=''>Error: No se recibió el ID del grupo.</option>";
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
