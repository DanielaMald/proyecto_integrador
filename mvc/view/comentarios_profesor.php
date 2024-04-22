<?php
// Funciones PHP para obtener datos de la base de datos y procesar comentarios
function obtenerGruposAsignados() {
    // Aquí iría tu lógica para obtener los grupos asignados al profesor desde la base de datos
    // Por ahora, estamos simulando datos de ejemplo
    return array(
        array('id' => 1, 'nombre' => 'Grupo A', 'materia' => 'Matemáticas'),
        array('id' => 2, 'nombre' => 'Grupo B', 'materia' => 'Historia'),
        array('id' => 3, 'nombre' => 'Grupo C', 'materia' => 'Ciencias')
    );
}

function obtenerComentariosPorGrupo($grupo_id) {
    // Aquí iría tu lógica para obtener los comentarios de un grupo específico desde la base de datos
    // Por ahora, estamos simulando datos de ejemplo
    return array(
        array('contenido' => 'Excelente trabajo', 'alumno' => 'Juan Pérez', 'matricula' => '12345'),
        array('contenido' => 'Necesita mejorar en esta área', 'alumno' => 'María González', 'matricula' => '67890')
    );
}

// Verificar si se ha seleccionado un grupo
if (isset($_GET['grupo_id'])) {
    $grupo_id = $_GET['grupo_id'];
    $comentarios = obtenerComentariosPorGrupo($grupo_id);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comentarios del Profesor</title>
    <!-- Aquí puedes incluir tus estilos CSS -->
</head>
<body>
    <div class="container">
        <h1>Comentarios del Profesor</h1>

        <!-- Lista de Grupos -->
        <div class="grupo-lista">
            <h2>Grupos Asignados</h2>
            <ul>
                <?php
                // Obtener y mostrar los grupos asignados al profesor
                $grupos_asignados = obtenerGruposAsignados();
                foreach ($grupos_asignados as $grupo) {
                    echo "<li><a href='comentarios_profesor.php?grupo_id=" . $grupo['id'] . "'>" . $grupo['nombre'] . " - " . $grupo['materia'] . "</a></li>";
                }
                ?>
            </ul>
        </div>

        <!-- Comentarios del Grupo Seleccionado -->
        <?php if (isset($comentarios)): ?>
        <div class="comentarios-grupo">
            <h2>Comentarios del Grupo</h2>
            <ul>
                <?php foreach ($comentarios as $comentario): ?>
                    <li><?= $comentario['contenido'] ?> - Alumno: <?= $comentario['alumno'] ?> (<?= $comentario['matricula'] ?>)</li>
                <?php endforeach; ?>
            </ul>

            <!-- Formulario para dejar un comentario para todos los alumnos del grupo -->
            <h3>Dejar Comentario para Todos</h3>
            <form action="procesar_comentario.php" method="POST">
                <input type="hidden" name="grupo_id" value="<?= $grupo_id ?>">
                <textarea name="comentario" rows="4" cols="50" required></textarea><br>
                <input type="submit" value="Enviar Comentario">
            </form>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>
