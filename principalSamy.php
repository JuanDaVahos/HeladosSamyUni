<?php
session_start();
// Verifica si la sesión ya ha sido iniciada
if (!isset($_SESSION['usuario'])) {
  // Si no ha iniciado sesión, redirige a la página de inicio de sesión
  header("Location: ./pages/login.html");
  exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./estilo.css">
  <link rel="icon" href="./source/icono.svg">
  <script src="./js/helados.js"></script>
  <script src="./js/carrito.js"></script>
  <title>Helados SAMY</title>
</head>

<body>
  <header>
    <div class="back">
      <div class="menu container">
        <a href="principalSamy.php" class="logo">
          <img src="./source/icono.webp" alt="Logo del negocio" title="HELADOS SAMY Logo">
        </a>
        <div>
          <a href="./pages/carrito.html"><label style="left: 100px;">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="icon-tabler-shopping-bag">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path
                  d="M6.331 8h11.339a2 2 0 0 1 1.977 2.304l-1.255 8.152a3 3 0 0 1 -2.966 2.544h-6.852a3 3 0 0 1 -2.965 -2.544l-1.255 -8.152a2 2 0 0 1 1.977 -2.304z" />
                <path d="M9 11v-5a3 3 0 0 1 6 0v5" />
              </svg>
            </label>
          </a>
          <label for="menu">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
              class="icon-tabler-menu">
              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
              <path d="M4 8l16 0" />
              <path d="M4 16l16 0" />
            </svg>
          </label>
        </div>
        <input type="checkbox" id="menu" />
        <nav class="navbar">
          <ul>
            <li>
              <a href="./principalSamy.php">Inicio</a>
            </li>
            <li>
              <a href="./pages/Info.html">Contacto</a>
            </li>
            <li>
              <a href="./pages/Trabajo.html">Trabaja con nosotros</a>
            </li>
            <li>
              <a href="./pages/carrito.html">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                  stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                  class="icon-tabler-shopping-bag">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                  <path
                    d="M6.331 8h11.339a2 2 0 0 1 1.977 2.304l-1.255 8.152a3 3 0 0 1 -2.966 2.544h-6.852a3 3 0 0 1 -2.965 -2.544l-1.255 -8.152a2 2 0 0 1 1.977 -2.304z" />
                  <path d="M9 11v-5a3 3 0 0 1 6 0v5" />
                </svg>
              </a>
            </li>
          </ul>
        </nav>
      </div>
    </div>
  </header>


  <main>
    <section id="sectionHelados" class="fila">
      <?php

      include "./db/conexionMySql.php";
      function mostrarHelados($helados)
      {
        foreach ($helados as $helado) {
          // Generamos los helados con PHP por que con java script no dio jajajjajajaja
          echo '<article class="helado">';
          echo '<div class="info-helado">';
          echo '<img src="' . $helado['imagen'] . '" alt="' . $helado['nombre'] . '">';
          echo '<h2>' . htmlspecialchars($helado['nombre']) . '</h2>';
          echo '<h3 class="precio-helado">$' . htmlspecialchars($helado['precio']) . '</h3>';
          echo '<button class="comprar" title="Comprar">+ Carrito</button>';
          echo '</div>';
          echo '</article>';
        }
      }

      $consulta = $conexion->prepare("SELECT * FROM helados");
      if ($consulta->execute()) {
        $resultado = $consulta->get_result();
        if ($resultado->num_rows > 0) {
          while ($fila = $resultado->fetch_assoc()) {
            $Helados[] = $fila;
          }
          if (!empty($Helados)) {
            mostrarHelados($Helados);
          }
        }
      }
      ?>
    </section>
  </main>

  <footer>
    <p class="copy">© 2025 Helados SAMY
      <strong>
        <a href="https://github.com/JuanDaVahos" target="_blank">@VahosDev</a>
      </strong>
    </p>
    <a href="./pages/Trabajo.html">Trabaja con nosotros</a>
  </footer>
</body>

</html>