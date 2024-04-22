<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../../styles/g2.css">
    <link rel="stylesheet" href="../../styles/formulario.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <title>Registro de asignaciones</title>
</head>
<body>
    <div class="site-header">
        <div id="desk">
            <div class="site-identity"></div>
            <nav>
                <ul class="button-list">
                    <li><button class="button" onclick="window.location.href='admin.html'">Inicio</button></li>
                    <li><button class="button" onclick="window.location.href='logout.php'">Salir</button></li>
                </ul>
            </nav>
        </div>
    </div>
    <h2 style="color: white;">Formulario de Asignaciones</h2>
    <form action="nueva_asignacion.php" method="post" class="formulario2">
        <label for="asignatura" style="color: black;">Asignatura:</label>
        <select id="asignatura" name="asignatura" required>
            <option value="">todos las materias</option>
            <?php
            foreach($resultado_asignaturas as $asignatura) {
                echo "<option value='" . $asignatura["nombre"] . "'>" . $asignatura["nombre"] . "</option>";
            }
            ?>
        </select><br>

        <label for="profesor" style="color: black;">Profesor:</label>
        <select id="profesor" name="profesor" required>
            <?php while ($fila_profesor = $resultado_profesores->fetch_assoc()): ?>
                <option value="<?php echo $fila_profesor['Nombre']; ?>"><?php echo $fila_profesor['Nombre']; ?></option>
            <?php endwhile; ?>
        </select><br>

        <label for="grupo" style="color: black;">Grupo:</label>
        <select name="grupo" id="grupo">
            <option value="">Todos los grupos</option>
            <?php
            foreach($resultados as $grupo) {
                echo "<option value='" . $grupo["nombre"] . "'>" . $grupo["nombre"] . "</option>";
            }
            ?>
        </select>
        <br>
        <label for="periodo">periodo</label>
        <select name="periodo" id="periodo">
        <option value="">Todos los periodos</option>
        <?php
            foreach($periodos as $periodo) {
                echo "<option value='" . $periodo["id_periodo"] . "'>" . $periodo["nombre"] . "</option>";
            }
            ?>
    </select>

        <input type="submit" value="Enviar" style="background-color: #3FABAF; color: white;">
    </form>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#periodo').change(function() {
        var periodoSeleccionado = $(this).val();
        // Envía una solicitud AJAX al servidor para obtener los grupos correspondientes al periodo seleccionado
        $.ajax({
            url: '../../controller/administrador/obtener_grupos_por_periodo.php',
            method: 'POST',
            data: { periodo: periodoSeleccionado },
            success: function(data) {
                // Actualiza dinámicamente el campo de selección de grupos con los resultados obtenidos
                $('#grupo').html(data);
            }
        });
    });
});
</script>
<script>
$(document).ready(function() {
    $('#periodo').change(function() {
        var periodoSeleccionado = $(this).val();
        // Envía una solicitud AJAX al servidor para obtener los grupos correspondientes al periodo seleccionado
        $.ajax({
            url: '../../controller/administrador/obtener_materias.php',
            method: 'POST',
            data: { periodo: periodoSeleccionado },
            success: function(data) {
                // Actualiza dinámicamente el campo de selección de grupos con los resultados obtenidos
                $('#asignatura').html(data);
            }
        });
    });
});
</script>
</html>



