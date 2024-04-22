<?php
require_once '../../model/administrador.php';
$estudianteModel = new Administrador();

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
    include "../../view/administrador/borrar_alumno2.php"; 
}elseif ($_SERVER["REQUEST_METHOD"] === "POST") {
        $matricula = $_POST["matricula"];
            $resultados = $estudianteModel->borrarEstudiante($matricula);
            include "../../view/administrador/borrar_alumno2.php"; 
            if ($resultados) {
                // Redireccionar al usuario a la página de inicio
                header("Location: ../../view/administrador/matriculas.php"); // Cambiar "/index.php" por la URL de la página de inicio de tu aplicación
                exit(); // Finalizar la ejecución del script para asegurar que la redirección se efectúe
            } else {
                // Mostrar algún mensaje de error si es necesario
                // Por ejemplo, puedes incluir un mensaje en la página de borrado
                include "../../view/administrador/actualizar_alumno2.php";
            }
    }
?>