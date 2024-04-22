<?php
session_start();

if (isset($_SESSION['clave_profesor'])) {
    $clave_profesor = $_SESSION['clave_profesor'];
} else {
    // Redireccionar al formulario de inicio de sesión si no hay sesión iniciada
    header('Location: login.php');
    exit;
}

// Realizar la conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "12345";
$database = "efi100cia2";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar si la conexión fue exitosa
if ($conn->connect_error) {
    die("Error en la conexión: " . $conn->connect_error);
}

// Verificar si se han enviado datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['alumnos']) && isset($_POST['asistencia']) && isset($_POST['id_asignatura']) && isset($_POST['id_grupo'])) {
    // Obtener los arrays de asistencia, matrículas y el ID de la asignatura
    $asistencias = $_POST['asistencia'];
    $alumnos = $_POST['alumnos'];
    $id_asignatura = $_POST['id_asignatura'];
    $id_grupo = $_POST['id_grupo'];

    // Iterar sobre los arrays para registrar la asistencia en la base de datos
    for ($i = 0; $i < count($alumnos); $i++) {
        $matricula = $alumnos[$i];
        
        // Verificar si se ha marcado la casilla de asistencia para este alumno
        $asistencia = in_array($matricula, $asistencias) ? 1 : 0; // 1 para asistencia, 0 para falta
        
        // Consulta SQL para insertar o actualizar la asistencia con la hora actual
        $sql = "INSERT INTO asistencias (matricula, asistencia, fecha, hora_entrada, clave_profesor, id_asignatura, id_grupo) 
                VALUES ('$matricula', $asistencia, CURDATE(), CURTIME(), '$clave_profesor', $id_asignatura, $id_grupo)
                ON DUPLICATE KEY UPDATE asistencia = $asistencia, fecha = CURDATE(), hora_entrada = CURTIME()";

        // Ejecutar la consulta
        if ($conn->query($sql) !== TRUE) {
            echo "Error al registrar la asistencia para la matrícula $matricula: " . $conn->error;
        }
    }

    // Redireccionar a la página anterior después de procesar los datos
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
} else {
    echo "Error: No se recibieron datos del formulario.";
}

// Cerrar la conexión
$conn->close();
?>
