//recogemos los elementos en variables
const btnArchivo = document.querySelector('.btn_input_archivo');
const inputArchivo = document.querySelector('#I-imagen');

//si se pulsa el boton de archivo
btnArchivo.addEventListener('click', () => {
  //se simula un click en el imput-file
  inputArchivo.click();
});

//si se selecciona un archivo
//activamos el evento change
// que lo que hace es: 
inputArchivo.addEventListener('change', () => {
  const archivo = inputArchivo.files[0];
  const reader = new FileReader();

  //cargamos la imagen
  reader.addEventListener('load', () => {
    const verImagen = document.querySelector('.ver_imagen');
    //si hay una imagen anterior, limpiamos el html del contenedor 
    //para que no se superpongan
    verImagen.innerHTML = '';
    const imagen = document.createElement('img');
    imagen.src = reader.result;
    verImagen.appendChild(imagen);
  });

  reader.readAsDataURL(archivo);
});
