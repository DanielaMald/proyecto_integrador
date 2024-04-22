<?php
$servername = "localhost";
$username = "root";
$password = "12345";
$dbname = "efi100cia2";

$conexion = new mysqli($servername, $username, $password, $dbname);

if ($conexion->connect_error) {
    die("Error de conexión a la base de datos: " . $conexion->connect_error);
}
?>