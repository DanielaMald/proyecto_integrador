<?php
require_once '../../model/administrador.php';
$estudianteModel = new Administrador();

// Obtener la lista de grupos
$periodos = $estudianteModel->obtenerTodosLosPeriodos();

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $matricula = $_GET['matricula'];
    
    $resultados_get = $estudianteModel->ObtenerDetalleAlumno($matricula);

    // Obtener detalles del estudiante
    $nombre = $resultados_get['nombre'];
    $apellido1 = $resultados_get['apellido1'];
    $apellido2 = $resultados_get['apellido2'];
    $fecha_nacimiento = $resultados_get['fecha_nacimiento'];
    $residencia = $resultados_get['residencia'];
    $correo = $resultados_get['correo'];

    // Variable para almacenar el ID del grupo
    $id_grupo = '';

    // Comprobar si se seleccionó un grupo en el formulario GET
    if (isset($_GET['grupo'])) {
        $grupo = $_GET['grupo'];
        // Obtener el ID del grupo seleccionado
        $id_grupo = $estudianteModel->obtenerIdGrupo($grupo);
    }

    include "../../view/administrador/actualizar_alumno2.php"; 
} elseif ($_SERVER["REQUEST_METHOD"] === "POST") {
    $matricula = $_POST["matricula"];
    // Verificar si se seleccionó un grupo en el formulario POST
    if (isset($_POST['grupo'])) {
        $grupo = $_POST['grupo'];
        // Obtener el ID del grupo seleccionado
        $id_grupo = $estudianteModel->obtenerIdGrupo($grupo);
        // Llamar al método para actualizar el grupo del estudiante
        $resultados = $estudianteModel->ActualizarEstudianteGrupo($matricula, $id_grupo);
        header("Location: ../../view/administrador/matriculas.php"); // Cambia "index.php" por la URL de tu índice real

        // Verificar si la actualización fue exitosa
        if ($resultados) {
            // Redirigir al usuario al índice
            header("Location: ../../view/administrador/matriculas.php"); // Cambia "index.php" por la URL de tu índice real
            exit; // Asegúrate de que el script se detenga después de la redirección
        } else {
            header( "../../view/administrador/actualizar_alumno2.php");
            // Manejar el caso en que ocurrió un error durante la actualización
            
            // Puedes redirigir al usuario a una página de error o mostrar un mensaje de error aquí
        }
    } else {
        // Manejar el caso en que no se seleccionó ningún grupo
        // Puedes redirigir al usuario a una página de error o mostrar un mensaje de error aquí
    }
}
?>
