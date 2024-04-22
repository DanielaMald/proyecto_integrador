<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "12345";
$dbname = "efi100cia2";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión a la base de datos: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION['clave_profesor']) && isset($_SESSION['nombre'])) {
        $clave_profesor = $_SESSION['clave_profesor'];
    } else {
        echo "Datos no encontrados";
        header('Location: index_profesor.html');
        exit;
    }

    // Obtener la materia seleccionada
    $materia_seleccionada = $conn->real_escape_string($_POST['materia_seleccionada']);

    // Consultar los comentarios correspondientes a la materia seleccionada
    $sql = "SELECT respuesta, matricula 
            FROM respuestas_profesor_alumno 
            WHERE clave_profesor = '$clave_profesor' AND id_asignatura = '$materia_seleccionada'";
    $result = $conn->query($sql);

    // Mostrar los comentarios en una tabla
    if ($result->num_rows > 0) {
        echo "<h2>Comentarios por Materia</h2>";
        echo "<table border='1'>";
        echo "<tr><th>Respuesta</th><th>Matrícula del Alumno</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row['respuesta'] . "</td><td>" . $row['matricula'] . "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "No se encontraron respuestas para esta materia.";
    }

    // Cerrar la conexión
    $conn->close();
} else {
    echo "Acceso no válido";
}
?>
