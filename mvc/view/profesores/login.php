<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../../styles/login.css" />
    <title>LOGIN</title>
</head>
<body>
    <div class="Main-container">      
        <div class="container-login">
            <div class="wrap-login">        
                <div class="site-identity"></div>
                <nav>
                    <ul>
                        <li><a href="../../views/profesores/index.html">Inicio</a></li>
                    </ul>
                </nav>

                <div class="login-pic">
                    <img src="https://oresedo.com/wp-content/uploads/2021/02/28-scaled.jpg" alt="IMG">
                </div>

                <?php
                session_start(); 

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $correo = $_POST['correo'];
                    $contrasena = $_POST['contrasena'];
                    $contrasena_md5 = md5($contrasena);
                    

                    // Realizar la conexión a la base de datos (asegúrate de configurar correctamente estos valores)
                    $servername = "localhost";
                    $username = "root";
                    $password = "12345";
                    $dbname = "efi100cia2";

                    // Conexión con la tabla administrador
                    $adminconn = new mysqli($servername, $username, $password, $dbname);
                    if ($adminconn->connect_error) {
                        die("Error de conexión a la base de datos: " . $adminconn->connect_error);
                    }

                    // Consulta para autenticar profesor
                    $stmt = $adminconn->prepare("SELECT clave_profesor, nombre, ap_paterno, ap_materno, correo FROM profesores WHERE correo = ? AND contrasena = ?");
                    $stmt->bind_param("ss", $correo, $contrasena_md5);
                    $stmt->execute();
                    $stmt->store_result();

                    if ($stmt->num_rows > 0) {
                        $stmt->bind_result($clave_profesor, $nombre, $ap_paterno, $ap_materno,$correo);
                        $stmt->fetch();
                        $_SESSION['correo'] = $correo;
                        $_SESSION['loggedin'] = true;
                        $_SESSION['clave_profesor'] = $clave_profesor;
                        $_SESSION['nombre'] = $nombre;
                        $_SESSION['ap_paterno'] = $ap_paterno;
                        $_SESSION['ap_materno'] = $ap_materno;
                        header('Location:index.html');
                        exit;
                    } else {
                        // Si ninguno de los anteriores, establece un mensaje de error
                        $error = "Credenciales inválidas";
                    }

                    $stmt->close();
                    $adminconn->close();

                    // Conexión con la tabla estudiantes_inscritos
                    $conn = new mysqli($servername, $username, $password, $dbname);
                    if ($conn->connect_error) {
                        die("Error de conexión a la base de datos: " . $conn->connect_error);
                    }

                    $stmt = $conn->prepare("SELECT matricula, nombre, apellido1, apellido2, fecha_nacimiento, residencia FROM estudiantes_inscritos WHERE correo = ? AND matricula = ?");
                    $stmt->bind_param("ss", $correo, $contrasena);
                    $stmt->execute();
                    $stmt->store_result();

                    if ($stmt->num_rows > 0) {
                        $stmt->bind_result($matricula, $nombre, $apellido1, $apellido2, $fecha_nacimiento, $residencia);
                        $stmt->fetch();
                        $_SESSION['correo'] = $correo;
                        $_SESSION['loggedin'] = true;
                        $_SESSION['matricula'] = $matricula;
                        $_SESSION['nombre'] = $nombre;
                        $_SESSION['apellido1'] = $apellido1;
                        $_SESSION['apellido2'] = $apellido2;
                        $_SESSION['fecha_nacimiento'] = $fecha_nacimiento;
                        $_SESSION['residencia'] = $residencia;
                        header('Location: ../../efi1002/alumnos_inscritos/index_padre_de_familia.html');
                        exit;
                    } else {
                        $error = "Credenciales inválidas";
                    }
                    $stmt->close();
                    $conn->close();
                }
                ?>

                <?php if (isset($error)) { ?>
                    <p><?php echo $error; ?></p>
                <?php } ?>

                <form class="login-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                    <span class="login-form-title">Login</span>

                    <div class="wrap-input">
                        <input type="text" class="input" id="correo" name="correo" placeholder="correo" required>
                        <span class="focus-input"></span>
                        <span class="symbol-input">
                            <i class="fa fa-envelope" aria-hidden="true"></i>
                        </span>
                    </div>
                    <div class="wrap-input">
                        <input type="password" class="input" name="contrasena" id="contrasena" placeholder="Password" required>
                        <span class="focus-input"></span>
                        <span class="symbol-input">
                            <i class="fa fa-lock" aria-hidden="true"></i>
                        </span>
                    </div>

                    <div class="login-form-btn-container">
                        <button class="login-form-btn">Login</button>
                    </div>

                    <div class="text-center p-t-1">
                        <span class="txt1">Forgot</span>
                        <a href="#" class="txt2"> Username / Password ?</a>
                    </div>
                    <div class="text-center p-t-2">
                        <a href="#" class="txt2">Create Your Account <i class="fa fa-long-arrow-right " aria-hidden="true"></i></a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
