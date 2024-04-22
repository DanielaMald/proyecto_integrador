<?php
// Verificar si se recibieron datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    // Recibir datos del formulario
    $id_grupo = isset($_POST["id_grupo"]) ? $_POST["id_grupo"] : "";
    $id_alumno = isset($_POST["id_alumno"]) ? $_POST["id_alumno"] : "";
    $id_materia = isset($_POST["id_asignatura"]) ? $_POST["id_asignatura"] : "";
    $asistencia = isset($_POST["asistencia"]) ? $_POST["asistencia"] : "";
    $fecha = isset($_POST["fecha"]) ? $_POST["fecha"] : "";
    // Inicia la sesión si no se ha iniciado ya
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $clave_profesor = isset($_SESSION['clave_profesor']) ? $_SESSION['clave_profesor'] : ""; // Recuperar clave de profesor de la sesión

    // Preparar la consulta SQL para insertar la calificación
    $sql = "INSERT INTO `asistencias` (`id_asistencia`, `id_alumno`, `id_asignatura`, `asistencia`, `fecha`, `id_grupo`, `clave_profesor`) VALUES (NULL, '$id_alumno', '$id_materia', '$asistencia', '$fecha', '$id_grupo', '$clave_profesor')";

    // Ejecutar la consulta
    if ($conn->query($sql) === TRUE) {
        echo "La asistencia se ha registrado correctamente.";
    } else {
        echo "Error al registrar la calificación: " . $conn->error;
    }

    // Cerrar la conexión
    $conn->close();
} else {
    echo "No se recibieron datos del formulario.";
}
?>
