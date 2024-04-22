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
                        <li><a href="../../index.html">Inicio</a></li>
                    </ul>
                </nav>

                <div class="login-pic">
                    <img src="https://oresedo.com/wp-content/uploads/2021/02/28-scaled.jpg" alt="IMG">
                </div>

                <?php
                if (isset($_GET['error'])) {
                    $error = $_GET['error'];
                    echo "<p>$error</p>";
                }
                ?>

                <form class="login-form" action="..\..\controller\administrador\login_index.php" method="POST">
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
