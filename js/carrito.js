const botonComprar = document.querySelectorAll('.comprar');

botonComprar.forEach(boton => {
  boton.addEventListener('click', () => {
    const divInfo = boton.closest('.info-helado');

    if (divInfo) {
      const imagenHelado = divInfo.querySelector('img')?.src || 'Imagen no disponible';
      const nombreHelado = divInfo.querySelector('h2')?.textContent || 'Nombre no disponible';
      const precioHelado = divInfo.querySelector('h3')?.textContent || 'Precio no disponible';

      // Crear un objeto para el helado
      const helado = { imagen: imagenHelado, nombre: nombreHelado, precio: precioHelado };

      // Obtener el carrito actual de localStorage
      const carrito = JSON.parse(localStorage.getItem('carrito')) || [];

      // Agregar el nuevo helado al carrito
      carrito.push(helado);

      // Guardar el carrito actualizado en localStorage
      localStorage.setItem('carrito', JSON.stringify(carrito));

      alert('Producto agregado al carrito');
    } else {
      console.error('No se encontró el contenedor .info-helado correspondiente.');
    }
  });
});


document.addEventListener('DOMContentLoaded', () => {
  const carritoContainer = document.querySelector('.carrito');
  if (carritoContainer) {
    const carrito = JSON.parse(localStorage.getItem('carrito')) || [];

    carrito.forEach(helado => {
      const nuevoElemento = document.createElement('div');
      nuevoElemento.classList.add('carrito-item');
      nuevoElemento.innerHTML = `
        <img src="${helado.imagen}" alt="${helado.nombre}">
        <h2>${helado.nombre}</h2>
        <h3>${helado.precio}</h3>
        <button class="eliminar">Eliminar</button>
      `;
      carritoContainer.appendChild(nuevoElemento);
    });
  }
  const eliminarBotones = document.querySelectorAll('.eliminar');
  
  eliminarBotones.forEach(boton => {
    boton.addEventListener('click', () => {
      const carritoContainer = document.querySelector('.carrito');
      const item = boton.closest('.carrito-item');
      if (item) {
        carritoContainer.removeChild(item);
      }
  
      // Actualizar el carrito en localStorage
      const carrito = JSON.parse(localStorage.getItem('carrito')) || [];
      const nombreHelado = item.querySelector('h2').textContent;
      const nuevoCarrito = carrito.filter(helado => helado.nombre !== nombreHelado);
      localStorage.setItem('carrito', JSON.stringify(nuevoCarrito));
    });
  
  })
});


