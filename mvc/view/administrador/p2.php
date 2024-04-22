<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <link rel="stylesheet" href="../../styles/g2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

    <title>profesors</title>

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
                    <li><button class="button" onclick="window.location.href='nuevo_profesor.html'">Registrar Profesor</button></li>
                    <li><button class="button" onclick="window.location.href='matriculas.php'">Matrículas</button></li>
                    <li><button class="button" onclick="window.location.href='logout.php'">Salir</button></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="container">
        <!-- Formulario para búsqueda por clave -->
        <form action="../../controller/administrador/profesores_controller.php" method="post">
            <label for="clave_profesor" style="color: white;">Buscar por Clave:</label>
            <input type="text" name="clave_profesor" id="clave_profesor" required>
            <input type="submit" value="Buscar">
        </form>

        <!-- Tabla de profesores inscritos -->
        <table class="table table-striped" bgcolor="#3FABAF">
            <tr>
                <th style="color: black;">Clave</th>
                <th style="color: black;">Nombre</th>
                <th style="color: black;">Apellido 1</th>
                <th style="color: black;">Apellido 2</th>
                <th style="color: black;">Correo</th>
            </tr>

            <!-- Mostrar datos en la tabla -->
            <?php foreach($resultados as $row): ?>
                <tr>
                    <td><?php echo $row["clave_profesor"]; ?></td>
                    <td><?php echo $row["nombre"]; ?></td>
                    <td><?php echo $row["ap_paterno"]; ?></td>
                    <td><?php echo $row["ap_materno"]; ?></td>
                    <td><?php echo $row["correo"]; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>

</html>
