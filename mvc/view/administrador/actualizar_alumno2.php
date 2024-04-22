<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../../styles/prueba.css">
    <link rel="stylesheet" href="../../styles/pagosacep.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
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
<div class="container">
    <h2>Modificar estudiante</h2>
    <label for="periodo">periodo</label>
    <select name="periodo" id="periodo">
        <option value="">Todos los periodos</option>
        <?php
        foreach($periodos as $periodo) {
            echo "<option value='" . $periodo["id_periodo"] . "'>" . $periodo["nombre"] . "</option>";
        }
        ?>
    </select>
    <form id="form" action="../../controller/administrador/actualizar_alumno.php?id=<?php echo $matricula; ?>" method="post">
        <div class="mb-3">
            <label for="matricula" class="form-label">Matrícula:</label>
            <input type="text" class="form-control" id="matricula" name="matricula" value="<?php echo $matricula; ?>" readonly>
        </div>
        <div class="mb-3">
        <label for="grupo" style="color: white;">Grupo:</label>
        <select name="grupo" id="grupo">
    <option value="">Todos los grupos</option>
    
</select><br>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="../../view/administrador/matriculas.php" class="btn btn-danger">Cancelar</a>
    </form>
</div>
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
</html>