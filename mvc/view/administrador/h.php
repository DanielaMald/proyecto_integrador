<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <link rel="stylesheet" href="../../styles/g2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <title>Chequeos</title>
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
                <li><button class="button" onclick="window.location.href='asignaciones.php'">Asignaciones</button></li>
                <li><button class="button" onclick="window.location.href='matriculas.php'">Matrículas</button></li>
                <li><button class="button" onclick="window.location.href='logout.php'">Salir</button></li>
            </ul>
        </nav>
    </div>
</header>   

<div class="container">
    <form action="#" method="post">
        <label for="fecha" style="color: white;">Filtrar por fecha:</label>
        <input type="date" name="fecha" id="fecha">
        <input type="submit" value="Filtrar por fecha">
    </form>

    <form action="#" method="post">
        <label for="salon" style="color: white;">Filtrar por salón:</label>
        <select name="salon" id="salon">
            <option value="">Todos los salones</option>
            <?php
            // Iterar sobre los salones obtenidos del controlador y mostrarlos en el select
            foreach($salones as $salon) {
                echo "<option value='" . $salon["id_salon"] . "'>" . $salon["nombre"] . "</option>";
            }
            ?>
        </select>
        <input type="submit" value="Filtrar por salón">
    </form>


    <!-- Tabla de asignaturas inscritas -->
    <table class="table table-striped" bgcolor="3FABAF">
        <tr>
            <th style="color: black;">nombre</th>
            <th style="color: black;">salon</th>
            <th style="color: black;">Fecha</th>
            <th style="color: black;">Hora</th>
        </tr>
        <?php
        while ($row = $resultados->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["NombreAlumno"] . "</td>";
            echo "<td>" . $row["NombreSalon"] . "</td>";
            echo "<td>" . $row["fecha"] . "</td>";
            echo "<td>" . $row["hora"] . "</td>";
            echo "</tr>";
        }
        ?>
    </table>
</div>

</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



</html>
