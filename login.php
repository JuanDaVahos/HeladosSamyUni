<?php
include('./db/conexionMySql.php');

if (isset($_POST["iniciarSesion"])) {
  $usuario = $_POST["usuario"];
  $contraseña = $_POST["contraseña"];
  $existe = 0;

  $consulta = $conexion->prepare("SELECT * FROM login WHERE BINARY usuario=?");
  $consulta->bind_param("s", $usuario);
  if ($consulta->execute()) {
    $resultado = $consulta->get_result();
    if ($resultado) {
      while ($resultados = $resultado->fetch_assoc()) {
        if (password_verify($contraseña, $resultados['contraseña'])) {
          $existe = 1;
          $usuario = $resultados['usuario'];
          $rol = $resultados['rol'];

          session_start();
          $_SESSION['usuario'] = $usuario;
          $_SESSION['rol'] = $rol;

          // Redirección basada en el rol
          if ($rol === 'admin') {
            header("Location: ./db/admin.php");
          } else {
            header("Location: ./index.php");
          }
          exit();
        }
      }
      if ($existe == 0) {
        echo "<script>
          alert('Usuario o contraseña incorrectos');
          window.history.go(-1);
        </script>";
      }
    } else {
      echo "<script>
        alert('Error al iniciar sesión');
        window.history.go(-1);
      </script>";
    }
  } else {
    echo "<script>
      alert('Error al iniciar sesión');
      window.history.go(-1);
    </script>";
  }
}
mysqli_close($conexion);
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
</head>

<body>
  <form action="index.php" method="post">
    <h1>Iniciar Sesión</h1>
    <input type="text" name="usuario" placeholder="Usuario" required>
    <input type="password" name="contraseña" placeholder="Contraseña" required>
    <div class="botones">
      <button name="iniciarSesion">Iniciar Sesión</button>
      <a href="./public/registrar.php">Registrarse</a>
    </div>
  </form>
</body>

<style>
  body {
    background-image: linear-gradient(to right top, #7b2f00, #631f12, #461617, #271013, #000000);
    display: flex;
    margin: 0;
    justify-content: center;
    align-items: center;
    height: 100vh;
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