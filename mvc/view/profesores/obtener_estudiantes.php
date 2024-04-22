<?php
// Verificar si se proporcionó el ID del grupo
if (isset($_GET['id_grupo'])) {
    $id_grupo = $_GET['id_grupo'];

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

    // Consulta SQL para obtener los estudiantes inscritos en el grupo seleccionado
    $sql_estudiantes = "SELECT matricula, nombre, apellido1, apellido2 FROM estudiantes_inscritos WHERE id_grupo = '$id_grupo'";
    $result_estudiantes = $conn->query($sql_estudiantes);

    if ($result_estudiantes->num_rows > 0) {
        // Construir opciones de selección para los estudiantes
        while ($row_estudiante = $result_estudiantes->fetch_assoc()) {
            echo "<option value='" . $row_estudiante["matricula"] . "'>" . $row_estudiante["nombre"] . " " . $row_estudiante["apellido1"] . " " . $row_estudiante["apellido2"] . "</option>";
        }
    } else {
        echo "<option>No hay estudiantes inscritos en este grupo</option>";
    }

    // Cerrar la conexión
    $conn->close();
} else {
    // Si no se proporcionó el ID del grupo, emitir un mensaje de error
    echo "Error: No se proporcionó el ID del grupo";
}
?>
