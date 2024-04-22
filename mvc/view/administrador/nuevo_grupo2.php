<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../../styles/g2.css">
    <link rel="stylesheet" href="../../styles/formulario.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <title>Registro</title>
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
    <h2 style="color: white;">Formulario de nuevo grupo</h2>
    <form action="../../controller/administrador/nuevo_grupo.php" method="post" class="formulario2">
        <label for="nombre" style="color: black;">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required><br>
        <label for="periodo">Periodo:</label>
        <select id="periodo" name="periodo" required>
            <?php while ($fila_periodo = $resultado_periodos->fetch_assoc()): ?>
                <option value="<?php echo $fila_periodo['Nombre']; ?>"><?php echo $fila_periodo['Nombre']; ?></option>
            <?php endwhile; ?>
        </select><br>
        <input type="submit" value="Enviar" style="background-color: #3FABAF; color: white;">
    </form>
</body>
</html>
