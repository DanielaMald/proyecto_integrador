<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <link rel="stylesheet" href="../../styles/g2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <title>Estudiantes</title>
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
                    </li>
                    <li><button class="button" onclick="window.location.href='logout.php'">Salir</button></li>
                </ul>
            </nav>
        </div>
    </header>
    <h4 style ="color:white;">Aqui inserta el documento csv para agregar alumnos de listas</h4>
<?php if (isset($_GET['status'])): ?>
    <?php if ($_GET['status'] == 'succ'): ?>
        <div class="success-msg" style="color: white;">Los datos se han importado correctamente.</div>
    <?php elseif ($_GET['status'] == 'err'): ?>
        <div class="error-msg" style="color: white;">Error al cargar el archivo CSV.</div>
    <?php elseif ($_GET['status'] == 'invalid_file'): ?>
        <div class="error-msg" style="color: white;">El archivo seleccionado no es válido. Por favor, selecciona un archivo CSV.</div>
    <?php elseif ($_GET['status'] == 'invalid_columns'): ?>
        <div class="error-msg" style="color: white;">El archivo CSV no contiene el número esperado de columnas.</div>
    <?php endif; ?>
<?php endif; ?>
    <form action="../../controller/administrador/importar_alumnos.php" method="post" enctype="multipart/form-data" style="color: white;">
    <input type="file" name="file" />
    <input type="submit" class="btn btn-primary" name="importSubmit" value="Importar">
</form>
<br><br>
    <div class="container">
    <form action="#" method="post">
    <label for="grupo" style="color: white;">Filtrar por grupo:</label>
    <select name="grupo" id="grupo">
    
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
    <br><br>
        <table class="table table-striped" bgcolor="#3FABAF">
        <thead>
            <tr>
                <th>Matrícula</th>
                <th>Nombre</th>
                <th>Apellido Paterno</th>
                <th>Apellido Materno</th>
                <th>Fecha de Nacimiento</th>
                <th>Residencia</th>
                <th>Correo</th>
                <th>Grupo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Aquí obtén los estudiantes de tu modelo Administrador

            foreach ($resultados as $estudiante) {
                echo "<tr>";
                echo "<td>{$estudiante['matricula']}</td>";
                echo "<td>{$estudiante['nombre_estudiante']}</td>";
                echo "<td>{$estudiante['apellido1']}</td>";
                echo "<td>{$estudiante['apellido2']}</td>";
                echo "<td>{$estudiante['fecha_nacimiento']}</td>";
                echo "<td>{$estudiante['residencia']}</td>";
                echo "<td>{$estudiante['correo']}</td>";
                echo "<td>{$estudiante['NombreGrupo']}</td>";
                echo "<td>
                        <a href='actualizar_alumno.php?matricula={$estudiante['matricula']}'>Actualizar</a>
                        <a href='borrar_alumno.php?matricula={$estudiante['matricula']}'>Borrar</a>
                      </td>";
                echo "</tr>";
            }
            ?>
        </tbody>
        </table>
    </div>
</body>
<script>
$(document).ready(function() {
    $('#periodo').change(function() {
        var periodoSeleccionado = $(this).val();
        // Envía una solicitud AJAX al servidor para obtener los grupos correspondientes al periodo seleccionado
        $.ajax({
            url: '../../controller/administrador/obtener_grupos_estudiantes.php',
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
