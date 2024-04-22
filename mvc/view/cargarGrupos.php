<?php
// Incluir la conexión a la base de datos
include('conexion.php');

// Verificar si se recibió el parámetro 'materia' enviado por POST
if (isset($_POST['materia'])) {
    $materiaSeleccionada = $_POST['materia'];
    
    // Obtener la clave del profesor de la sesión
    session_start();
    if (isset($_SESSION['clave_profesor'])) {
        $clave_profesor = $_SESSION['clave_profesor'];

        // Consulta SQL para obtener los grupos asociados a la materia seleccionada y asignados al profesor
        $sql_grupos = "SELECT grupos.id_grupo, grupos.nombre 
                       FROM grupos 
                       INNER JOIN asignacionmaterias ON grupos.id_grupo = asignacionmaterias.id_grupo 
                       WHERE asignacionmaterias.id_asignatura = $materiaSeleccionada 
                       AND asignacionmaterias.clave_profesor = '$clave_profesor'";
        
        $resultado_grupos = $conn->query($sql_grupos);

        // Verificar si se encontraron grupos
        if ($resultado_grupos->num_rows > 0) {
            // Construir las opciones de los grupos
            $opciones = '';
            while ($row_grupo = $resultado_grupos->fetch_assoc()) {
                $opciones .= "<option value='{$row_grupo['id_grupo']}'>{$row_grupo['nombre']}</option>";
            }
            echo $opciones;
        } else {
            echo "<option value=''>No se encontraron grupos para esta materia.</option>";
        }
    } else {
        echo "<option value=''>Error: No se pudo obtener la clave del profesor.</option>";
    }
} else {
    echo "<option value=''>Error: No se recibió la materia.</option>";
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
