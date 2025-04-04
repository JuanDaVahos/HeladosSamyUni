const botonesComprar = document.querySelectorAll('.comprar');

botonesComprar.forEach(boton => {
  boton.addEventListener('click', () => {
    const divInfo = boton.closest('.info-helado');

    if (divInfo) {
      const imagenHelado = divInfo.querySelector('img')?.src || 'Imagen no disponible';
      const nombreHelado = divInfo.querySelector('h2')?.textContent || 'Nombre no disponible';
      const precioHelado = divInfo.querySelector('h3')?.textContent || 'Precio no disponible';

      const helado = { imagen: imagenHelado, nombre: nombreHelado, precio: precioHelado };
      const carrito = JSON.parse(localStorage.getItem('carrito')) || [];
      carrito.push(helado);
      localStorage.setItem('carrito', JSON.stringify(carrito));

      alert('Producto agregado al carrito');
    } else {
      console.error('No se encontró el contenedor .info-helado correspondiente.');
    }
  });
});

document.addEventListener('DOMContentLoaded', () => {
  const contenedorCarrito = document.querySelector('.carrito');
  if (contenedorCarrito) {
    const carrito = JSON.parse(localStorage.getItem('carrito')) || [];

    // Crear objeto para contar helados
    const contadorHelados = carrito.reduce((acumulador, helado) => {
      acumulador[helado.nombre] = (acumulador[helado.nombre] || 0) + 1;
      return acumulador;
    }, {});

    // Crear elementos únicos para cada helado
    Object.entries(contadorHelados).forEach(([nombre, cantidad]) => {
      const helado = carrito.find(h => h.nombre === nombre);
      const elementoCarrito = document.createElement('div');
      elementoCarrito.classList.add('carrito-item');
      elementoCarrito.innerHTML = `
        <img src="${helado.imagen}" alt="${helado.nombre}">
        <h2>${helado.nombre}</h2>
        <h3>${helado.precio}</h3>
        <h4>Cantidad: ${cantidad}</h4>
        <button class="eliminar">Eliminar</button>
      `;
      contenedorCarrito.appendChild(elementoCarrito);
    });
  }

  const botonesEliminar = document.querySelectorAll('.eliminar');

  botonesEliminar.forEach(boton => {
    boton.addEventListener('click', () => {
      const contenedorCarrito = document.querySelector('.carrito');
      const elemento = boton.closest('.carrito-item');
      if (elemento) {
        contenedorCarrito.removeChild(elemento);
      }

      const carrito = JSON.parse(localStorage.getItem('carrito')) || [];
      const nombreHelado = elemento.querySelector('h2').textContent;
      const carritoActualizado = carrito.filter(helado => helado.nombre !== nombreHelado);
      localStorage.setItem('carrito', JSON.stringify(carritoActualizado));
    });
  });
});


