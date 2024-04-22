<?php
// Archivo "conexion.php" (Asegúrate de definir los valores correctos para tu base de datos)
$host = 'localhost';
$usuario = 'root';
$contrasena = '12345';
$base_de_datos = 'efi100cia2';

$conexion = mysqli_connect($host, $usuario, $contrasena, $base_de_datos);
mysqli_set_charset($conexion, "utf8");
if (!$conexion) {
    die('Error: No se pudo conectar a la base de datos. ' . mysqli_connect_error());
}
?>