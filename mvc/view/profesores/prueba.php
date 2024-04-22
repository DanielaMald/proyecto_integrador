<?php
// Conexión a la base de datos (sustituye con tus datos)
include "../../controllers/administrador/conexion.php";

// Consulta para obtener todos los estudiantes inscritos
$sql = "SELECT matricula, nombre, apellido1, apellido2 FROM estudiantes_inscritos";
$result = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Asistencia</title>
    <!-- Encabezado y enlaces a estilos y scripts -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    <!-- Cabecera y menú -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">Registro de Asistencia</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../../views/administrador/admin.html">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../../controllers/profesores/mostrar_asistencia.php">Mostrar asistencia</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../../controllers/administrador/matriculas.php">Matrículas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../../controllers/profesores/historial_asistencia.php">Historial</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../../controllers/profesores/logout.php">Salir</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <div class="container">
        <!-- Formulario para marcar asistencia -->
        <form action="actualizar_asistencia.php" method="post">
            <table class="table table-striped">
                <tr>
                    <th>Matrícula</th>
                    <th>Nombre</th>
                    <th>Apellido 1</th>
                    <th>Apellido 2</th>
                    <th>Asistencia</th>
                </tr>
                <?php
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["matricula"] . "</td>";
                        echo "<td>" . $row["nombre"] . "</td>";
                        echo "<td>" . $row["apellido1"] . "</td>";
                        echo "<td>" . $row["apellido2"] . "</td>";
                        echo "<td>";
                        echo '<input type="hidden" name="matricula[]" value="' . $row['matricula'] . '">';
                        echo '<input type="checkbox" name="asistencia[]" value="1"> Presente';
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No se encontraron estudiantes inscritos.</td></tr>";
                }
                ?>
            </table>
            <button type="submit" class="btn btn-primary">Guardar Asistencia</button>
        </form>
    </div>
</body>
</html>

<?php
// Cerrar la conexión a la base de datos
if(isset($conexion)) {
    $conexion->close();
}
?>