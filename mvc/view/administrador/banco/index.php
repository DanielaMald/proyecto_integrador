<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <link rel="stylesheet" href="../stylei.css">
    <link rel="stylesheet" href="banco.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

    <title>banco</title>

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


$resultado = $conn->query("SELECT * FROM folios_banco");

?>
<h4 style ="color:white;">Aqui inserta el documento csv que te ha enviado el banco</h4>
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


<form action="importar.php" method="post" enctype="multipart/form-data" style="color: white;">
    <input type="file" name="file" />
    <input type="submit" class="btn btn-primary" name="importSubmit" value="Importar">
</form>

<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th>folios_banco</th>
            <th>fecha de pago</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($resultado->num_rows > 0) {
            while ($row = $resultado->fetch_assoc()) {
                $folios_banco = $row['folios_banco'];
                $fecha_pago = $row['fecha_pago'];
               
                ?>
                <tr>
                    <td><?php echo $folios_banco; ?></td>
                    <td><?php echo $fecha_pago; ?></td>
                </tr>
                <?php
            }
        } else {
            ?>
            <tr>
                <td colspan="6" style="color: white;">No se encontraron registros.</td>
            </tr>
            <?php
        }
        ?>
    </tbody>
</table>
</div>
    </body>
<script>
    function formToggle(folios_banco) {
        var element = document.getElementById(folios_banco);
        if (element.style.display === "none") {
            element.style.display = "block";
        } else {
            element.style.display = "none";
        }
    }
</script>
</html>