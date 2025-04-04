<?php

include("../db/conexionMySql.php");

if (isset($_POST['enviar'])) {
  $nombre = $_POST['nombre'];
  $correo = $_POST['correo'];
  $telefono = $_POST['telefono'];
  $mensaje = $_POST['mensaje'];

  $consulta = $conexion->prepare("INSERT INTO trabajo (nombre,correo,telefono,motivo) VALUES (?,?,?,?)");

  $consulta->bind_param("ssss", $nombre, $correo, $telefono, $mensaje);

  if ($consulta->execute()) {
    echo "<script>alert('Enviado con exito, te contactaremos pronto 😊')</script>";
    echo "<script>window.history.go(-1);</script>";
  } else {
    echo "<script>alert('❌ALGO FALLO❌')</script>";
  }
}

?>