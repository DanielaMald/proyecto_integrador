<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <link rel="stylesheet" href="../../styles/g2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <title>Asignaturas</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
        integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</head>
<body style="background-color: #4ed7db;">
<header class="site-header">
    <div id="desk">
        <div class="site-identity"></div>
        <nav>
            <ul>
                <li><button class="button" onclick="window.location.href='admin.html'">Inicio</button></li>
                <li><button class="button" onclick="window.location.href='nueva_materia.php'">Registrar asignatura</button></li>
                <li><button class="button" onclick="window.location.href='nueva_asignacion.php'">Registrar Asignacion</button></li>
                <li><button class="button" onclick="window.location.href='asignaciones.php'">Asignaciones</button></li>
                <li><button class="button" onclick="window.location.href='matriculas.php'">Matrículas</button></li>
                <li><button class="button" onclick="window.location.href='logout.php'">Salir</button></li>
            </ul>
        </nav>
    </div>
</header>   

<div class="container">
<form action="#" method="post">
    <label for="grupo" style="color: white;">Filtrar por grupo:</label>
    <select name="grupo" id="grupo">
    <option value="">Todos los grupos</option>
    
</select>
    
    <input type="submit" value="Filtrar">
</form>
<select name="periodo" id="periodo">
        <option value="">Todos los periodos</option>
        <?php
            // Iterar sobre los períodos obtenidos del controlador y mostrarlos en el select
            foreach($periodos as $periodo) {
                echo "<option value='" . $periodo["id_periodo"] . "'>" . $periodo["nombre"] . "</option>";
            }
            ?>
    </select>

    <!-- Tabla de asignaturas inscritas -->
    <table class="table table-striped" bgcolor="3FABAF">
        <tr>
            <th style="color: black;">Asignatura</th>
            <th style="color: black;">Profesor</th>
            <th style="color: black;">Grupo</th>
        </tr>
        <?php
        while ($row = $asignaciones->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["NombreAsignatura"] . "</td>";
            echo "<td>" . $row["NombreProfesor"] . "</td>";
            echo "<td>" . $row["NombreGrupo"] . "</td>";
            echo "</tr>";
        }
        ?>
    </table>
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
