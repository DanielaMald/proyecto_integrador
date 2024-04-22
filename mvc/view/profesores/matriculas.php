<?php
session_start();

if (isset($_SESSION['clave_profesor']) && isset($_SESSION['nombre']) && isset($_SESSION['ap_paterno']) && isset($_SESSION['ap_materno'])) {
    $clave_profesor = $_SESSION['clave_profesor'];
    $nombre = $_SESSION['nombre'];
    $ap_paterno = $_SESSION['ap_paterno'];
    $ap_materno = $_SESSION['ap_materno'];
    $correo = $_SESSION['correo'];
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

// Consulta SQL para obtener las materias asignadas al profesor
$sql_materias = "SELECT DISTINCT asignacionmaterias.id_asignatura, asignaturas.nombre AS nombre_asignatura
               FROM asignacionmaterias
               INNER JOIN asignaturas ON asignacionmaterias.id_asignatura = asignaturas.id_asignatura
               WHERE asignacionmaterias.clave_profesor = '$clave_profesor'";

$result_materias = $conn->query($sql_materias);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../styles/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <title>Alumnos Asignados</title>
    <style>
        body {
            background-color: #83B5F1;
            color: white; /* Color de letra */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            color: white; /* Color de letra de la tabla */
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #3FABAF;
            color: black; /* Color de letra de las cabeceras */
        }

        button {
            background-color: #ddd; /* Color de fondo del botón */
            color: black; /* Color de letra del botón */
            border: none;
            padding: 4px 10px;
            cursor: pointer;
            border-radius: 4px;
        }

        button:hover {
            background-color: #2E7B7F; /* Color de fondo del botón al pasar el mouse */
        }
    </style>
</head>
<body>
    <header class="site-header">
        <div id="desk">
            <div class="site-identity"></div>
            <nav>
                <ul>
                    <li><button class="button" onclick="window.location.href='../../view/profesores/index.html'">Inicio</button></li>
                    <li><button class="button" onclick="window.location.href='../../view/profesores/mostrar_asistencia.php'">Mostrar asistencia</button></li>
                    <li><button class="button" onclick="window.location.href='../../view/profesores/historial_asistencia_alumno.php'">Historial</button></li>
                    <li><button class="button" onclick="window.location.href='../../controllers/profesores/logout.php'">Salir</button></li>
                </ul>
            </nav>
        </div>
    </header>
    <br>
    <br>
    <div class="container">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="materia">Seleccionar materia:</label>
            <select name="materia" id="materia">
                <?php
                // Mostrar opciones de selección para las materias
                if ($result_materias && $result_materias->num_rows > 0) {
                    while ($row = $result_materias->fetch_assoc()) {
                        echo "<option value='" . $row['id_asignatura'] . "'>" . $row['nombre_asignatura'] . "</option>";
                    }
                } else {
                    echo "<option value=''>No se encontraron materias asignadas.</option>";
                }
                ?>
            </select>

            <label for="grupo">Seleccionar grupo:</label>
            <select name="grupo" id="grupo">
                <?php
                // Cargar los grupos después de seleccionar una materia
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['materia'])) {
                    $id_asignatura_seleccionada = $_POST['materia']; // Asignar el valor de la materia seleccionada

                    // Consulta SQL para obtener los grupos asociados a la materia seleccionada
                    $sql_grupos = "SELECT DISTINCT asignacionmaterias.id_grupo, grupos.nombre AS nombre_grupo
                                FROM asignacionmaterias
                                INNER JOIN grupos ON asignacionmaterias.id_grupo = grupos.id_grupo
                                WHERE asignacionmaterias.id_asignatura = $id_asignatura_seleccionada";

                    $result_grupos = $conn->query($sql_grupos);

                    if ($result_grupos && $result_grupos->num_rows > 0) {
                        while ($row = $result_grupos->fetch_assoc()) {
                            echo "<option value='" . $row['id_grupo'] . "'>" . $row['nombre_grupo'] . "</option>";
                        }
                    } else {
                        echo "<option value=''>No se encontraron grupos asignados a esta materia.</option>";
                    }
                }
                ?>
            </select>

            <input type="submit" value="Mostrar Alumnos">
        </form>

        <?php
        // Si se ha seleccionado una materia y un grupo, mostrar los alumnos asignados a ese grupo
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['materia']) && isset($_POST['grupo'])) {
            $id_grupo_seleccionado = $_POST['grupo'];
            $id_asignatura_seleccionada = $_POST['materia'];

            // Consulta SQL para obtener los datos de los alumnos asignados al grupo seleccionado
            $sql_alumnos = "SELECT matricula, nombre, apellido1, apellido2 
                            FROM estudiantes_inscritos 
                            WHERE id_grupo = $id_grupo_seleccionado";
            $result_alumnos = $conn->query($sql_alumnos);

            echo "<h2>Alumnos Asignados al Grupo</h2>";
            echo "<form method='post' action='actualizar_asistencia.php'>";
            echo "<input type='hidden' name='id_asignatura' value='$id_asignatura_seleccionada'>";
            echo "<input type='hidden' name='id_grupo' value='$id_grupo_seleccionado'>";
            echo "<table>";
            echo "<tr><th style='color: black;'>Nombre</th><th style='color: black;'>Matrícula</th><th style='color: black;'>Asistencia</th></tr>";

            if ($result_alumnos && $result_alumnos->num_rows > 0) {
                while ($row = $result_alumnos->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["nombre"] . " " . $row["apellido1"] . " " . $row["apellido2"] . "</td>";
                    echo "<td>" . $row["matricula"] . "</td>";
                    echo "<td>";
                    echo '<input type="hidden" name="alumnos[]" value="' . $row["matricula"] . '">';
                    echo '<input type="checkbox" name="asistencia[]" value="' . $row["matricula"] . '"> Asistencia';
                    echo '<input type="hidden" name="falta[]" value="0">'; // Valor oculto para indicar falta

                    echo "</td>";

                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No se encontraron alumnos asignados a este grupo.</td></tr>";
            }
            echo "</table>";
            echo "<input type='submit' value='Registrar Asistencia'>";
            echo "</form>";
        }
        ?>


    </div>
</body>
</html>
