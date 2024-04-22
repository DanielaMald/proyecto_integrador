<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <link rel="stylesheet" href="estilo.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

    <title>nuevo ingreso</title>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
        integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</head>
<body style="background-color: #182f53;">
<header class="site-header">
    <div id="desk">
        <div class="site-identity"></div>
        <nav>
            <ul>
                <li><button class="button" onclick="window.location.href='../admin.html'">Inicio</button></li>
                <li><button class="button" onclick="window.location.href='../documentacion.php'">Documentación</button></li>
                <li><button class="button" onclick="window.location.href='../matriculas.php'">Matrículas</button></li>
                <li><button class="button" onclick="window.location.href='../logout.php'">salir</button></li>
            </ul>
        </nav>
    </div>
</header>
</body>
<div class="container">
<?php

$servername = "localhost";
$username = "root";
$password = "12345";
$dbname = "efi100cia2";

$conn = new mysqli($servername, $username, $password, $dbname, 3306);

if ($conn->connect_error) {
    die("Error de conexión a la base de datos: " . $conn->connect_error);
}

$resultado = $conn->query("SELECT * FROM estudiantes_aceptados");

?>

<?php if (isset($_GET['status'])): ?>
    <?php if ($_GET['status'] == 'succ'): ?>
        <div class="success-msg">Los datos se han importado correctamente.</div>
    <?php elseif ($_GET['status'] == 'err'): ?>
        <div class="error-msg">Error al cargar el archivo CSV.</div>
    <?php elseif ($_GET['status'] == 'invalid_file'): ?>
        <div class="error-msg">El archivo seleccionado no es válido. Por favor, selecciona un archivo CSV.</div>
    <?php elseif ($_GET['status'] == 'invalid_columns'): ?>
        <div class="error-msg">El archivo CSV no contiene el número esperado de columnas.</div>
    <?php endif; ?>
<?php endif; ?>

<h4 style ="color:white;">Aqui inserta el documento csv con la lista de alumnos previamente aceptados</h4>
<form action="importar.php" method="post" enctype="multipart/form-data">
    <input type="file" name="file" />
    <input type="submit" class="btn btn-primary" name="importSubmit" value="Importar">
</form>

<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
    <thead class="thead-dark">
        <tr>
            <th>folio_estudiante</th>
            <th>Nombre</th>
            <th>apellido1</th>
            <th>apellido2</th>
            <th>Periodo</th>
            <th>correo</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Verificar si hay filas en el resultado
        if ($resultado->num_rows > 0) {
            // Iterar sobre cada fila del resultado
            while ($row = $resultado->fetch_assoc()) {
                // Obtener los valores de las columnas
                $folio_estudiante = $row['folio_estudiante'];
                $nombre = $row['nombre'];
                $apellido1 = $row['apellido1'];
                $apellido2 = $row['apellido2'];
                $periodo = $row['periodo'];
                $correo = $row['correo'];
                ?>
                <tr>
                    <td><?php echo $folio_estudiante; ?></td>
                    <td><?php echo $nombre; ?></td>
                    <td><?php echo $apellido1; ?></td>
                    <td><?php echo $apellido2; ?></td>
                    <td><?php echo $periodo; ?></td>
                    <td><?php echo $correo; ?></td>
                </tr>
                <?php
            }
        } else {
            ?>
            <tr>
                <td colspan="6">No se encontraron registros.</td>
            </tr>
            <?php
        }
        ?>
    </tbody>
</table>
    </div>
    </body>
<script>
    function formToggle(folio_estudiante) {
        var element = document.getElementById(folio_estudiante);
        if (element.style.display === "none") {
            element.style.display = "block";
        } else {
            element.style.display = "none";
        }
    }
</script>
</html>