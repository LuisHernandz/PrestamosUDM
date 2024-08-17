// const input = document.querySelector('.input');
// const contenedor = document.querySelectorAll('.container-input');

// Seleccionar todos los elementos con la clase "contenedor"
const contenedores = document.querySelectorAll('.container-input');

// Iterar sobre cada contenedor
contenedores.forEach(contenedor => {
  // Seleccionar el input dentro de cada contenedor
  const input = contenedor.querySelector('input');

  // Agregar evento focus
  input.addEventListener('focus', () => {
    contenedor.classList.add('focus');
  });

  // Agregar evento blur
  input.addEventListener('blur', () => {
    contenedor.classList.remove('focus');
  });
});
