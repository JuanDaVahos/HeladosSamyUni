<?php

//incluimos el codigo del otro archivo, el cual hace la conexion, es como si trajesemos ese codigo aquí
include("./conexionMySql.php");

/////////////////////////////////////////////////////////////////////
// Iniciamos la sesión para poder usar las variables de sesión
session_start();

// Comprobamos si el usuario ya ha iniciado sesión
if (!isset($_SESSION['usuario']) || empty($_SESSION['usuario'])) {
  // Lo redirigimos a la página de login
  header("Location: ../login.php");
  exit();
}

// Verifica si el usuario es administrador
if ($_SESSION['rol'] !== 'admin') {
  // Si no es administrador, redirige a la página principal
  header("Location: ../index.php"); // Cambiar a principalSamy.php si es necesario
  exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./styles.css">
  <title>Administración</title>
</head>

<body>
  <h1>Bienvenido Administrador</h1>

  <?php

  //este if lo que hace es que si pulsa en boton enviar y haga la consulta, se guarden los datos en las variables
  if (isset($_POST["btn_enviar"])) {
    $id = $_POST["id"];
    $nombre = $_POST["nombre"];
    $precio = $_POST["precio"];

    //hacemos una consulta de SELECT a la base de datos, para saber si el id del nuevo helado ya existe
    $consulta = $conexion->prepare("SELECT id FROM helados WHERE id=?");
    $consulta->bind_param("s", $id);
    $consulta->execute();
    $resultado = $consulta->get_result();
    //si el la consulta intenta modificar alguna fila, quiere decir que el id ya existe
    if ($resultado->num_rows > 0) {
      echo "<script>alert('El id ya existe');</script>";
      echo "<script>window.history.go(-1);';</script>";
    }

    //este if lo que hace es verificar si se selecciono una imagen y si la subio correctamente
    if (isset($_FILES['I-imagen']) && $_FILES['I-imagen']['error'] === UPLOAD_ERR_OK) {

      //recogemos la información de la imagen en una variable
      $archivo = $_FILES['I-imagen'];

      //hacemos una validacion para los tipos de archivos que se pueden subir
      //en este caso solo se pueden subir archivos .webp, para optimizar la página web
      $tiposPermitidos = ['image/webp'];

      //si el usuario intenta subir otro archivo que no sea .webp, le decimos que ni mierda, no se puede jaja
      if (!in_array($archivo['type'], $tiposPermitidos)) {
        echo "<script>alert('Solo se permiten archivos .webp');</script>";

        //este escrip lo usaremos mucho
        //lo que hace es rediregir al usuario a la pagina principal
        //para que al actualizar la pagina no se vuelva a hacer el proceso
        echo "<script>window.history.go(-1);;</script>";
      }

      //time(), es para que el nombre de la imagen sea unico
      //basado en los segundos que han pasado desde el 1 de enero de 1970
  
      //basename(), devuelve el nombre del archivo
      $nombreArchivo = time() . '_' . basename($archivo['name']);

      //se le agrega imagen/ al nombre de la imagen
      //seria algo como image/imagen.webp
      //y esta ruta se guarda en la base de datos para poder acceder a la imagen
      $imagen = 'image/' . $nombreArchivo;

      //ahora hacemos una consulta de INSERT a la base de datos
      //en el campo imagen se guarda la ruta de la imagen
      $consulta = $conexion->prepare("INSERT INTO helados(id,nombre,imagen,precio) VALUES(?,?,?,?)");
      $consulta->bind_param("ssss", $id, $nombre, $imagen, $precio);

      //si la consulta se ejecuta correctamente
      if ($consulta->execute()) {

        //../image/, es la ruta de la carpeta donde se guardan las imagenes
        $directorioSubida = '../image/';

        //si la carpeta no existe la creamos, es solo para evitar errores
        if (!file_exists($directorioSubida)) {
          mkdir($directorioSubida, 0777, true);
        }

        //es la ruta donde se guarda la imagen
        //../image/imagen.webp
        $rutaSubida = $directorioSubida . $nombreArchivo;

        //momevos el archivo que php tiene temporalmente guardado, (tmp_name)
        //a la ruta que acabamos de crear
        //si se mueve correctamente
        if (move_uploaded_file($archivo['tmp_name'], $rutaSubida)) {
          echo "<script>alert('Helado agregado correctamente');</script>";
          echo "<script>window.history.go(-1);;</script>";
        } else {
          $conexion->query("DELETE FROM helados WHERE id='$id'");
          echo "<script>alert('Error al subir la imagen. Código: " . $archivo['error'] . "');</script>";
          echo "<script>window.history.go(-1);;</script>";
        }
      } else {
        echo "<script>alert('Error al guardar en la base de datos: " . $conexion->error . "');</script>";
        echo "<script>window.history.go(-1);;</script>";
      }
    } else {
      echo "<script>alert('No se seleccionó ninguna imagen o hubo un error en la subida');</script>";
      echo "<script>window.history.go(-1);;</script>";
    }
    echo "<script>window.history.go(-1);;</script>";
  }

  ////////////////////////////////////////////////////////////////////
  //hacemos una consulta de SELECT a la base de datos
  
  //comprobamos si se pulso el boton consultar
  if (isset($_POST["btn_consultar"])) {
    //guardamos el id en una variable
    $id = $_POST["id"];
    //creamos una switch para saber si el helado existe
    $existe = 0;

    //hacemos una consulta de SELECT a la base de datos
    $consultaHelados = $conexion->prepare("SELECT * FROM helados WHERE id=?");
    $consultaHelados->bind_param("s", $id);

    //si la consulta se ejecuta correctamente
    if ($consultaHelados->execute()) {

      //obtenemso los resultados de la consulta en un objeto Mysqli_result
      //esto nos permitira manipularlos
      $resultado = $consultaHelados->get_result();

      //si hay resultados
      if ($resultado) {

        //recorremos cada una de las columnas de la consulta o del campo de la base de datos
        while ($datosHelado = $resultado->fetch_assoc()) {
          //como el helado existe, esta variable pasa a 1
          $existe = 1;

          //recogemos los datos del helado en variables para manipularlos
          $id = $datosHelado['id'];
          $nombre = $datosHelado['nombre'];
          $imagen = $datosHelado['imagen'];
          $precio = $datosHelado['precio'];
        }
        //si el helado no existe, se le avisa al usuario
        if ($existe == 0) {
          echo "<script>alert('No se encontró ningún helado con ese ID');</script>";
          echo "<script>window.history.go(-1);;</script>";
        }
      } else {
        echo "<script>alert('Error al obtener el resultado');</script>";
        echo "<script>window.history.go(-1);;</script>";
      }
    } else {
      echo "<script>alert('Error en la consulta');</script>";
      echo "<script>window.history.go(-1);;</script>";
    }
  }

  ////////////////////////////////////////////////////////////////////
  //hacer consulta de UPDATE, para modificar los datos del helado
  if (isset($_POST["btn_actualizar"])) {
    $id = $_POST["id"];
    $nombre = $_POST["nombre"];
    $precio = $_POST["precio"];

    //comprobamos si se selecciono una imagen
    if (isset($_FILES['I-imagen']) && $_FILES['I-imagen']['error'] === UPLOAD_ERR_OK) {
      $archivo = $_FILES['I-imagen'];

      //hacemos una consulta de SELECT para saber la ruta de la imgen antigua
      $consulta = $conexion->prepare("SELECT imagen FROM helados WHERE id=?");
      $consulta->bind_param("s", $id);
      $consulta->execute();
      //obtenemos los resultados (la ruta de la imagen antigua)
      $resultado = $consulta->get_result();
      //recorremos el campo imagen
      $imagenAntigua = $resultado->fetch_assoc()['imagen'];

      //hacemos una validacion para los tipos de archivos que se pueden subir
      $tiposPermitidos = ['image/webp'];

      //si el usuario intenta subir otro archivo que no sea .webp, le decimos que ni mierda, no se puede jaja
      if (!in_array($archivo['type'], $tiposPermitidos)) {
        echo "<script>alert('Solo se permiten archivos .webp');</script>";
        echo "<script>window.history.go(-1);;</script>";
      }

      //time(), es para que el nombre de la imagen sea unico
      //basado en los segundos que han pasado desde el 1 de enero de 1970
      //basename(), devuelve el nombre del archivo
      $nombreArchivo = time() . '_' . basename($archivo['name']);

      //se le agrega imagen/ al nombre de la imagen
      //seria algo como image/imagen.webp
      $imagen = 'image/' . $nombreArchivo;


      //ahora hacemos una consulta de UPDATE a la base de datos
      //en el campo imagen se guardara la nueva ruta de la nueva imagen
      $consulta = $conexion->prepare("UPDATE helados SET nombre=?, imagen=?, precio=? WHERE id=?");
      $consulta->bind_param("ssss", $nombre, $imagen, $precio, $id);

      //si la consulta se ejecuta correctamente
      if ($consulta->execute()) {

        //si la imagen antigua existe
        if ($imagenAntigua) {

          //creamos la ruta valida, para la imagen antigua
          $rutaImagenAntigua = '../' . $imagenAntigua;

          //si la imagen antigua existe
          if (file_exists($rutaImagenAntigua)) {
            //try/catch es para manejar errores y no para el programa
            try {
              //si no se puede eliminar la imagen, le decimos que nanai, no sirvio juas juas
              if (!unlink($rutaImagenAntigua)) {
                error_log("No se pudo eliminar el archivo: " . $rutaImagenAntigua);
              }
            }
            //si se produce un error mayor, lo capturamos y continuamos con la ejecucion 
            catch (Exception $e) {
              error_log("Error al eliminar el archivo: " . $e->getMessage());
            }
          }
        }

        //creamos la ruta de la carpeta donde se guardan las imagenes
        $directorioSubida = '../image/';
        if (!file_exists($directorioSubida)) {
          mkdir($directorioSubida, 0777, true);
        }

        //creamos la ruta de la nueva imagen
        //../image/imagen.webp
        $rutaSubida = $directorioSubida . $nombreArchivo;

        //moveremos la imagen a la nueva ruta
        //si se mueve correctamente
        //move_uploaded_file, es para mover el archivo
        //tmp_name, es para saber la ruta temporal de la imagen
        if (move_uploaded_file($archivo['tmp_name'], $rutaSubida)) {
          echo "<script>alert('Helado actualizado correctamente');</script>";
          echo "<script>window.history.go(-1);;</script>";
        } else {
          echo "<script>alert('Error al subir la imagen. Código: " . $file['error'] . "');</script>";
          echo "<script>window.history.go(-1);;</script>";
        }
      } else {
        echo "<script>alert('Error al guardar en la base de datos: " . $conexion->error . "');</script>";
        echo "<script>window.history.go(-1);;</script>";
      }
    } else {
      echo "<script>alert('No se seleccionó ninguna imagen o hubo un error en la subida');</script>";
      echo "<script>window.history.go(-1);;</script>";
    }
  }
  //////////////////////////////////////////////////////////////////////
  
  //si se pulsa el boton eliminar ->
  if (isset($_POST["btn_eliminar"])) {
    $id = $_POST["id"];

    // Verificamos si el ID está presente
    if (!empty($id)) {
      // Hacemos una consulta de SELECT para obtener la ruta de la imagen asociada al helado
      $consulta = $conexion->prepare("SELECT imagen FROM helados WHERE id=?");
      $consulta->bind_param("s", $id);
      $consulta->execute();
      $resultado = $consulta->get_result();

      // Si se encuentra el helado
      if ($resultado->num_rows > 0) {
        $imagenAntigua = $resultado->fetch_assoc()['imagen'];

        // Hacemos la consulta DELETE para eliminar el helado
        $consulta = $conexion->prepare("DELETE FROM helados WHERE id = ?");
        $consulta->bind_param("s", $id);

        if ($consulta->execute()) {
          // Si hay una imagen asociada, intentamos eliminarla
          if (!empty($imagenAntigua)) {
            $rutaImagenAntigua = '../' . $imagenAntigua;

            if (file_exists($rutaImagenAntigua)) {
              try {
                if (!unlink($rutaImagenAntigua)) {
                  error_log("No se pudo eliminar el archivo: " . $rutaImagenAntigua);
                }
              } catch (Exception $e) {
                error_log("Error al eliminar el archivo: " . $e->getMessage());
              }
            }
          }
          echo "<script>alert('Helado eliminado exitosamente');</script>";
        } else {
          echo "<script>alert('Error al eliminar el helado de la base de datos');</script>";
        }
      } else {
        echo "<script>alert('No se encontró ningún helado con ese ID');</script>";
      }
    } else {
      echo "<script>alert('Por favor, ingrese un ID válido');</script>";
    }
    echo "<script>window.history.go(-1);;</script>";
  }

  //cerramos la conexion a la base de datos
  mysqli_close($conexion);
  ?>
  <!-- ////////////////////formulario//////////////////////////////// -->
  <form action="./index.php" method="POST" enctype="multipart/form-data">
    <label for="id">Id Helado:</label>
    <input type="text" name="id" id="id" value="<?php echo isset($id) ? $id : ''; ?>" required>
    <label for="nombre">Nombre Helado:</label>
    <input type="text" name="nombre" id="nombre" value="<?php echo isset($nombre) ? $nombre : ''; ?>">

    <h2>Imagen</h2>
    <button class="btn_input_archivo" type="button">Selecciona archivo</button>
    <input type="file" name="I-imagen" id="I-imagen" accept="image/webp" hidden>
    <div class="ver_imagen">
      <img src="../<?php echo isset($imagen) ? $imagen : ''; ?>" alt="">
    </div>
    <label for="precio">Precio Helado:</label>
    <input type="text" name="precio" id="precio" value="<?php echo isset($precio) ? $precio : ''; ?>">
    <div class="botones">
      <button name="btn_enviar">Enviar</button>
      <button name="btn_consultar">Consultar</button>
      <button name="btn_actualizar">Actualizar</button>
      <button name="btn_eliminar">Eliminar</button>
      <button type="reset" name="btn_Limpiar">Limpiar</button>
    </div>
  </form>
  <script src="../js/indexPHP.js" defer></script>
</body>

</html>