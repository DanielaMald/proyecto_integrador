<?php
$servername = "localhost";
$username = "root";
$password = "12345";
$dbname = "efi100cia2";

$conn = new mysqli($servername, $username, $password, $dbname, 3306);

if ($conn->connect_error) {
    die("Error de conexión a la base de datos: " . $conn->connect_error);
}
?>