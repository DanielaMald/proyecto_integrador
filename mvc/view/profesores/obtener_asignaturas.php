<?php
// Verificar si se proporcionó el ID del profesor
if (isset($_GET['id_profesor'])) {
    $id_profesor = $_GET['id_profesor'];

    // Conexión a la base de datos (modifica los datos de conexión según tu configuración)
    $servername = "localhost";
    $username = "root";
    $password = "12345";
    $dbname = "efi100cia2";

    // Crear conexión
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    // Consulta SQL para obtener las asignaturas asignadas al profesor
    $sql_asignaturas = "SELECT id_asignatura, nombre FROM asignaturas WHERE id_asignatura IN (SELECT id_asignatura FROM asignacionmaterias WHERE clave_profesor = '$id_profesor')";
    $result_asignaturas = $conn->query($sql_asignaturas);

    if ($result_asignaturas->num_rows > 0) {
        // Construir opciones de selección para las asignaturas
        while ($row_asignatura = $result_asignaturas->fetch_assoc()) {
            echo "<option value='" . $row_asignatura["id_asignatura"] . "'>" . $row_asignatura["nombre"] . "</option>";
        }
    } else {
        echo "<option value=''>No hay asignaturas disponibles</option>";
    }

    // Cerrar la conexión
    $conn->close();
} else {
    // Si no se proporcionó el ID del profesor, emitir un mensaje de error
    echo "Error: No se proporcionó el ID del profesor";
}
?>
