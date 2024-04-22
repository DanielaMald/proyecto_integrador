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
    <h2>Borrar estudiante</h2>
    <form id="form" action="../../controller/administrador/borrar_alumno.php?id=<?php echo $matricula; ?>" method="post">
        <div class="mb-3">
            <label for="matricula" class="form-label">Matrícula:</label>
            <input type="text" class="form-control" id="matricula" name="matricula" value="<?php echo $matricula; ?>" readonly>
        </div>
        <div class="mb-3">
            <label for="nombre" class="form-label" >Nombre:</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $nombre; ?>" readonly>
        </div>
        <div class="mb-3">
            <label for="apellido1" class="form-label">Apellido1:</label>
            <input type="text" class="form-control" id="apellido1" name="apellido1" value="<?php echo $apellido1; ?>" readonly>
        </div>
        <div class="mb-3">
            <label for="apellido2" class="form-label" >Apellido2:</label>
            <input type="text" class="form-control" id="apellido2" name="apellido2" value="<?php echo $apellido2; ?>" readonly>
        </div>
        
        <button type="submit" class="btn btn-primary">Borrar</button>
        <a href="../../view/administrador/matriculas.php" class="btn btn-danger">Cancelar</a>
    </form>
</div>
</body>
</html>