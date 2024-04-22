<?php
session_start();

if (isset($_SESSION['clave_profesor']) && isset($_SESSION['nombre']) && isset($_SESSION['ap_paterno']) && isset($_SESSION['ap_materno'])) {
    $clave_profesor = $_SESSION['clave_profesor'];
    $nombre = $_SESSION['nombre'];
    $ap_paterno = $_SESSION['ap_paterno'];
    $ap_materno = $_SESSION['ap_materno'];
    $correo = $_SESSION['correo'];
} else {
    // Redireccionar al formulario de inicio de sesión si no hay sesión iniciada
    header('Location: login.php');
    exit;
}

// Verificar si se ha enviado el formulario de actualización
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los nuevos valores enviados desde el formulario
    $nuevoNombre = $_POST['nombre'];
    $nuevoap_paterno = $_POST['ap_paterno'];
    $nuevoap_materno = $_POST['ap_materno'];
    

    // Actualizar los datos en la sesión
    $_SESSION['nombre'] = $nuevoNombre;
    $_SESSION['ap_paterno'] = $nuevoap_paterno;
    $_SESSION['ap_materno'] = $nuevoap_materno;
   

    // Actualizar los datos en la base de datos
    // Aquí debes agregar tu lógica para actualizar los datos en la base de datos
    // Dependiendo de cómo esté configurada tu base de datos, puedes utilizar consultas SQL o un ORM para realizar la actualización

    // Ejemplo de consulta SQL para actualizar los datos en la tabla profesores
    $servername = "localhost";
    $username = "root";
    $password = "12345";
    $database = "efi100cia2";

    // Crear conexión
    $conn = new mysqli($servername, $username, $password, $database);

    // Verificar si la conexión fue exitosa
    if ($conn->connect_error) {
        die("Error en la conexión: " . $conn->connect_error);
    }

    // Consulta SQL para actualizar los datos
    $sql = "UPDATE profesores SET nombre='$nuevoNombre', ap_paterno='$nuevoap_paterno', ap_materno='$nuevoap_materno', fecha_nacimiento='$nuevaFechaNacimiento', residencia='$nuevoResidencia' WHERE clave_profesor=$clave_profesor";

    if ($conn->query($sql) === TRUE) {
        // Redireccionar al perfil actualizado
        header('Location: perfil.php');
        exit;
    } else {
        echo "Error al actualizar los datos en la base de datos: " . $conn->error;
    }

    $conn->close();
}
?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../styles/profesor/admin.css">
    <title>Perfil de Profesor</title>
</head>
<body>
    <header class="site-header">
    <nav>
            <ul>
            <li><button class="button" onclick="window.location.href='../../views/profesores/index.html'">Inicio</button></li>

            </ul>
        </nav>
    </header>
    <div class="content">
        <h1 style="color: white;">Perfil del profesor</h1>
        <div id="profile-container">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                <div>
                    <label for="clave_profesor" style="color: white;">Matrícula:</label>
                    <span><?php echo $clave_profesor; ?></span>
                </div>
                <div>
                    <label for="nombre" style="color: white;">Nombre:</label>
                    <input type="text" name="nombre" value="<?php echo $nombre; ?>" required>
                </div>
                <div>
                    <label for="ap_paterno" style="color: white;">Apellido Paterno:</label>
                    <input type="text" name="ap_paterno" value="<?php echo $ap_paterno; ?>" required>
                </div>
                <div>
                    <label for="ap_materno" style="color: white;">Apellido Materno:</label>
                    <input type="text" name="ap_materno" value="<?php echo $ap_materno; ?>" required>
                </div>
                
                <button type="submit" style="color: white;">Guardar</button>
            </form>
            <div>
                <label for="correo" style="color: white;">Correo:</label>
                <span><?php echo $correo; ?></span>
            </div>
        </div>
    </div>
</body>
</html>
