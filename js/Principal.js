//aqui vamos a manipular el index.html

//empecemos con la seccion de helados

//obtenemos el elemento section con id sectionHelados
const sectionHelados = document.getElementById("sectionHelados");

// funcion para mostrar e integrar los helados a la pagina y al HTML
function mostrarHelados(Helados){
  Helados.forEach(helado => {
    //creamos un elemento article, el cual sera el contenedor de cada helado
    const newHelado = document.createElement("article");
    newHelado.classList = "helado";
    //agregamos el helado a la seccion de helados
    newHelado.innerHTML = `
      <div class="info-helado">
        <img src="${helado.imagen}" alt="Ensalada de frutas" title="Ensalada de frutas">
        <h2 class="nombre-helado">${helado.nombre}</h2>
        <h3 class="precio-helado">$${helado.precio}</h3>
        <button class="comprar" title="comprar">+ Carrito</button>
      </div>
    `;
    sectionHelados.appendChild(newHelado);
    newHelado.getElementsByTagName("button")[0].addEventListener("click", () => aggCarrito(helado));
  });
};


mostrarHelados(helados);