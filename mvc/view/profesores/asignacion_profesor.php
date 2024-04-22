<?php
session_start();

if (isset($_SESSION['clave_profesor']) && isset($_SESSION['nombre']) && isset($_SESSION['ap_paterno']) && isset($_SESSION['ap_materno'])) {
    $clave_profesor = $_SESSION['clave_profesor'];
    $nombre = $_SESSION['nombre'];
    $ap_paterno = $_SESSION['ap_paterno'];
    $ap_materno = $_SESSION['ap_materno'];
    $correo = $_SESSION['correo'];
} else {
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

// Consulta SQL para obtener las materias asignadas y los grupos asociados al profesor
$sql = "SELECT asignacionmaterias.id_asignatura, asignacionmaterias.id_grupo, asignacionmaterias.clave_profesor, materias.nombre AS nombre_materia, grupos.nombre AS nombre_grupo
        FROM asignacionmaterias
        INNER JOIN materias ON asignacionmaterias.id_asignatura = materias.id_asignatura
        INNER JOIN grupos ON asignacionmaterias.id_grupo = grupos.id_grupo
        WHERE asignacionmaterias.clave_profesor = $clave_profesor";

$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../styles/profesor/admin.css">
    <title>Perfil de Estudiante</title>
</head>
<body>
    <header class="site-header">
        <nav>
            <ul>
                <li><button class="button" onclick="window.location.href='../../views/profesores/index.html'">Inicio</button></li>
            </ul>
        </nav>
    </header>
    <div class="content">
        <h1 style="color: white;">Materias Asignadas</h1>
        <div id="profile-container">
            <table style="color: white;">
                <tr>
                    <th>Materia</th>
                    <th>Grupo</th>
                </tr>
                <?php
                // Mostrar los resultados de la consulta en la tabla
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['nombre_materia'] . "</td>";
                        echo "<td>" . $row['nombre_grupo'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='2'>No se encontraron materias asignadas.</td></tr>";
                }
                ?>
            </table>
        </div>
    </div>
</body>
</html>
