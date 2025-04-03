<?php

use Dba\Connection;

//que cosa mas dificil de hacer jajaja, pero se logro, al final si toco usar PHP para usar la base de datos en my webHost

// $host = "sql102.infinityfree.com";
// $user = "if0_38215341";
// $password = "YMuyztXOBI";
// $database = "if0_38215341_samydb";

$host = "localhost";
$user = "root";
$password = "";
$database = "prueba";

$conexion = new mysqli($host, $user, $password, $database);

if ($conexion->connect_error) {
    die("❌ Error de conexión: " . $conexion->connect_error);
}
?>