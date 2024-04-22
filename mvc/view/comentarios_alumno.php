<?php
// Incluir la conexión a la base de datos
include('conexion.php');

// Verificar si se ha enviado la matrícula del alumno
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['matricula'])) {
    // Obtener la matrícula del alumno desde la URL
    $matricula = $_GET['matricula'];

    // Consulta SQL para obtener los comentarios del alumno según su matrícula
    $sql = "SELECT comentario FROM comentarios_profesor_alumno WHERE matricula_alumno = '$matricula'";
    $resultado = $conn->query($sql);

    if ($resultado->num_rows > 0) {
        // Matrícula válida, obtener los comentarios
        $comentarios = array();
        while ($row = $resultado->fetch_assoc()) {
            $comentarios[] = $row['comentario'];
        }
        // Devolver los comentarios en formato JSON
        echo json_encode($comentarios);
    } else {
        // Matrícula no encontrada en la base de datos
        echo "No se encontraron comentarios para la matrícula proporcionada.";
    }
} else {
    // Error si no se proporcionó la matrícula
    echo "Error: No se proporcionó la matrícula del alumno.";
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
