<?php
// Conexión a la base de datos (reemplaza con tus propios datos)
include "../../controller/administrador/conexion.php";

// Verificar si se envió el formulario de asistencia
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir los datos del formulario
    $fecha = $_POST['fecha'];
    $hora_entrada = $_POST['hora_entrada'];
    $hora_salida = $_POST['hora_salida'];
    $matricula_alumno = $_POST['matricula_alumno'];
    $asistencia = $_POST['asistencia'];

    // Insertar registro de asistencia en la base de datos
    $sql = "INSERT INTO asistencia_alumno (fecha, hora_entrada, hora_salida, matricula_alumno, asistencia) VALUES ('$fecha', '$hora_entrada', '$hora_salida', '$matricula_alumno', '$asistencia')";
    if ($conexion->query($sql) === TRUE) {
        echo "Asistencia registrada correctamente.";
    } else {
        echo "Error al registrar la asistencia: " . $conexion->error;
    }
}

// Mostrar formulario para registrar asistencia
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Asistencia</title>
</head>
<body>
    <h2>Registrar Asistencia</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="fecha">Fecha:</label>
        <input type="date" name="fecha" required><br><br>
        
        <label for="hora_entrada">Hora de Entrada:</label>
        <input type="time" name="hora_entrada" required><br><br>

        <label for="hora_salida">Hora de Salida:</label>
        <input type="time" name="hora_salida" required><br><br>

        <label for="matricula_alumno">Matrícula del Alumno:</label>
        <input type="text" name="matricula_alumno" required><br><br>

        <label for="asistencia">Asistencia:</label>
        <select name="asistencia">
            <option value="0">Ausente</option>
            <option value="1">Presente</option>
        </select><br><br>

        <input type="submit" value="Registrar">
    </form>
</body>
</html>
