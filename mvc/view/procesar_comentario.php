<?php
// Iniciar sesión si aún no está iniciada
session_start();

// Verificar si se han enviado datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['matricula']) && isset($_POST['comentario']) && isset($_POST['id_asignatura']) && isset($_POST['id_grupo'])) {
    // Verificar si se ha iniciado sesión como profesor y obtener su clave de profesor
    if (isset($_SESSION['clave_profesor'])) {
        // La sesión está iniciada, obtener la clave del profesor
        $clave_profesor = $_SESSION['clave_profesor'];

        // Incluir la conexión a la base de datos
        include('conexion.php');

        // Verificar la conexión a la base de datos
        if ($conn->connect_error) {
            die("Error en la conexión a la base de datos: " . $conn->connect_error);
        }

        // Obtener los datos del formulario y escaparlos para prevenir inyección de SQL
        $matricula = $conn->real_escape_string($_POST['matricula']);
        $comentario = $conn->real_escape_string($_POST['comentario']);
        $id_asignatura = $conn->real_escape_string($_POST['id_asignatura']);
        $id_grupo = $conn->real_escape_string($_POST['id_grupo']);

        // Preparar la consulta para insertar el comentario
        $stmt = $conn->prepare("INSERT INTO comentarios_profesor_alumno (clave_profesor, matricula, comentario, id_asignatura, id_grupo) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issii", $clave_profesor, $matricula, $comentario, $id_asignatura, $id_grupo);

        // Ejecutar la consulta
        echo "Matrícula: " . $matricula . "<br>";
        echo "Comentario: " . $comentario . "<br>";
        echo "ID de asignatura: " . $id_asignatura . "<br>";
        echo "ID de grupo: " . $id_grupo . "<br>";

        if ($stmt->execute()) {
            echo "Comentario enviado correctamente.";
        } else {
            echo "Error al enviar el comentario. Por favor, inténtalo de nuevo. Error: " . $stmt->error;
        }

        // Cerrar la conexión
        $stmt->close();
    } else {
        echo "No se ha iniciado sesión como profesor.";
    }
} else {
    echo "No se recibieron datos del formulario correctamente.";
}
?>
