<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registrarse en S A M Y</title>
</head>

<body>
  <?php
  include('../db/conexionMySql.php');

  if (isset($_POST["registrarse"])) {
    $usuario = $_POST["usuario"];
    $contraseña =($_POST["contraseña"]);
    $contraseñaEncriptada = password_hash($contraseña, PASSWORD_DEFAULT);
    
    if (strlen($usuario) < 8){
      echo "<script>alert('el usuario debe tener almenos 8 caracteres');
      window.history.go(-1)</script>";
    } elseif (strlen($contraseña)  < 8){
      echo "<script>alert('la contraseña debe tener almenos 8 caracteres');</script>";
    } else {
      // Verificamos si el usuario ya existe
      $consulta = $conexion->prepare("SELECT usuario FROM login WHERE usuario = ?");
      $consulta->bind_param("s", $usuario);
      $consulta->execute();
      $resultado = $consulta->get_result();
  
      if ($resultado->num_rows > 0) {
        // Si el usuario ya existe, mostramos un mensaje de error
        echo "<script>alert('El usuario ya está registrado. Por favor, elige otro nombre de usuario.');</script>";
        echo "<script>window.history.go(-1);</script>";
      } else {
        // Si el usuario no existe, procedemos a registrarlo
        $consulta = $conexion->prepare("INSERT INTO login (usuario, contraseña) VALUES (?,?)");
        $consulta->bind_param("ss", $usuario, $contraseñaEncriptada);
  
        if ($consulta->execute()) {
          echo "<script>alert('Has sido registrado 😊');</script>";
          echo "<script>window.location.href = '../index.php';</script>";
        } else {
          echo "<script>alert('Error al registrar');</script>";
          echo "<script>window.history.go(-1);</script>";
        }
      }
    }
  }
  ?>
  <form action="registrar.php" method="post">
    <h1>Registrarse</h1>
    <input type="text" name="usuario" placeholder="Usuario">
    <input type="password" name="contraseña" placeholder="Contraseña">
    <div class="botones">
      <button name="registrarse">Registrarse</button>
    </div>
  </form>
</body>

<style>
  body {
    background-image: linear-gradient(to right top, #7b2f00, #631f12, #461617, #271013, #000000);
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
  }

  form {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    gap: 10px;
    padding: 20px;
    background: rgba(123, 47, 0, 0.4);
    border: 1px solid #000;
    border-radius: 15px;
    color: #fff;
    box-shadow: 0 0 20px 1px #000;
  }

  h1 {
    font-size: 2em;
    text-shadow: 0px 0px 15px #fff;
  }

  input {
    padding: 10px;
    border-radius: 5px;
    border: 1px solid #ccc;
  }

  button,
  a {
    padding: 10px;
    border-radius: 5px;
    border: 1px solid #ccc;
    background-color: #7b2f00;
    color: #fff;
    cursor: pointer;

    &:hover {
      background-color: #511d12;
    }
  }
</style>

</html>