<?php
session_start();

if (isset($_SESSION['clave_profesor'])) {
    $clave_profesor = $_SESSION['clave_profesor'];

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

    // Consulta SQL para obtener los grupos asignados al profesor
    $sql_grupos = "SELECT id_grupo FROM asignacionmaterias WHERE clave_profesor = '$clave_profesor'";
    $result_grupos = $conn->query($sql_grupos);

    // Cerrar la conexión
    $conn->close();
} else {
    // Si no hay una sesión de profesor activa, redireccionar al formulario de inicio de sesión
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
        <link rel="stylesheet" href="../../styles/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de asistenciaes</title>
</head>
<body>
    <header class="site-header"><nav>
            <ul>
                <li><button class="button" onclick="window.location.href='perfil.php'">Perfil</button></li>
                <li><button class="button" onclick="window.location.href='index.html'">inicio</button></li>
                <li><button class="button" onclick="window.location.href='logout.php'">Salir</button></li>
                
            </ul>
        </nav></header>
    <h2>Formulario de asistenciaes</h2>
    <form action="procesar_asistencia.php" method="POST">
        <label for="clave_profesor" style="color: white;">Clave del profesor:</label>
        <span style="color:white;" ><?php echo $clave_profesor; ?></span>
        <br>
        <label for="id_grupo">ID del Grupo:</label>
        <select id="id_grupo" name="id_grupo">
            <?php
            if ($result_grupos->num_rows > 0) {
                while ($row_grupo = $result_grupos->fetch_assoc()) {
                    echo "<option value='" . $row_grupo["id_grupo"] . "'>" . $row_grupo["id_grupo"] . "</option>";
                }
            } else {
                echo "<option value=''>No hay grupos disponibles</option>";
            }
            ?>
        </select>
        <br><br>
        <label for="asistencia">asistencia:</label>
        <input type="text" id="asistencia" name="asistencia"><br><br>
        
        <label for="fecha">fecha:</label>
        <input type="date" id="fecha" name="fecha"><br><br>
        
        <label for="id_alumno">Selecciona un alumno:</label>
        <select id="id_alumno" name="id_alumno">
            <option value="">Seleccione un grupo primero</option>
        </select>
        
        <label for="id_asignatura">ID de la asignatura:</label>
        <select id="id_asignatura" name="id_asignatura">
            <option value="">Seleccione un grupo primero</option>
        </select>
        
        <br><br>
        <input type="submit" value="Guardar Calificación">
        
        <!-- Script para cargar dinámicamente los estudiantes según el grupo seleccionado -->
        <script>
            document.getElementById('id_grupo').addEventListener('change', function() {
                var idGrupo = this.value;
                var xhr = new XMLHttpRequest();
                xhr.open('GET', 'obtener_estudiantes.php?id_grupo=' + idGrupo, true);
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        document.getElementById('id_alumno').innerHTML = xhr.responseText;
                    }
                };
                xhr.send();
            });
            
            // Script para cargar dinámicamente las asignaturas según el profesor seleccionado
            document.addEventListener('DOMContentLoaded', function() {
                var idProfesor = '<?php echo $clave_profesor; ?>';
                var xhr = new XMLHttpRequest();
                xhr.open('GET', 'obtener_asignaturas.php?id_profesor=' + idProfesor, true);
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        document.getElementById('id_asignatura').innerHTML = xhr.responseText;
                    }
                };
                xhr.send();
            });
        </script>
    </form>
</body>
</html>
