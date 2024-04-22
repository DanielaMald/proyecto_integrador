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
    $sql = "SELECT R.respuesta, R.matricula, CONCAT(E.nombre, ' ', E.apellido1, ' ', E.apellido2) AS nombre_completo, G.nombre AS grupo
            FROM respuestas_profesor_alumno R
            JOIN estudiantes_inscritos E ON R.matricula = E.matricula
            JOIN grupos G ON E.id_grupo = G.id_grupo
            WHERE R.clave_profesor = '$clave_profesor' AND R.id_asignatura = '$materia_seleccionada'";
    $result = $conn->query($sql);

    // Mostrar los comentarios en una tabla
    if ($result->num_rows > 0) {
        $comments_table = "<h2>Comentarios por Materia</h2>";
        $comments_table .= "<table border='1'>";
        $comments_table .= "<tr><th>Respuesta</th><th>Nombre del Alumno</th><th>Matrícula del Alumno</th><th>Grupo</th></tr>";
        while ($row = $result->fetch_assoc()) {
            $comments_table .= "<tr><td>" . $row['respuesta'] . "</td><td>" . $row['nombre_completo'] . "</td><td>" . $row['matricula'] . "</td><td>" . $row['grupo'] . "</td></tr>";
        }
        $comments_table .= "</table>";
    } else {
        $comments_table = "No se encontraron respuestas para esta materia.";
    }
}

// Consultar las materias en las que el profesor tiene asignaciones
if (isset($_SESSION['clave_profesor']) && isset($_SESSION['nombre'])) {
    $clave_profesor = $_SESSION['clave_profesor'];

    // Consultar las materias asignadas al profesor
    $sql_materias = "SELECT DISTINCT AM.id_asignatura, A.nombre AS materia 
                    FROM asignacionmaterias AM 
                    JOIN asignaturas A ON AM.id_asignatura = A.id_asignatura 
                    WHERE AM.clave_profesor = '$clave_profesor'";
    $result_materias = $conn->query($sql_materias);

    // Verificar si la consulta fue exitosa
    if (!$result_materias) {
        die("Error al obtener las materias: " . $conn->error);
    }
} else {
    echo "Datos no encontrados";
    header('login.php');
    exit;
}

// Cerrar la conexión
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comentarios por Materia</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        h1 {
            text-align: center;
        }
        form {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .back-btn {
            display: block;
            text-align: center;
            margin-top: 20px;
            text-decoration: none;
            color: #333;
            background-color: #f9f9f9;
            border: 1px solid #ccc;
            padding: 8px 16px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Comentarios por Materia</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <label for="materia">Seleccione una materia:</label>
            <select name="materia_seleccionada" id="materia">
                <?php
                // Mostrar las materias disponibles en el menú desplegable
                while ($row_materia = $result_materias->fetch_assoc()) {
                    echo "<option value='" . $row_materia['id_asignatura'] . "'>" . $row_materia['materia'] . "</option>";
                }
                ?>
            </select>
            <button type="submit">Mostrar Comentarios</button>
        </form>
        <?php
        if (isset($comments_table)) {
            echo $comments_table;
        }
        ?>
        <a href="../view/profesores/index.html" class="back-btn">Regresar al Inicio</a>
    </div>
</body>
</html>
