function establecerPaginacion() {
    const fila = document.querySelector('.contenedor-carousel');
    const peliculas = document.querySelectorAll('.pelicula');

    const flechaIzquierda = document.getElementById('flecha-izquierda');
    const flechaDerecha = document.getElementById('flecha-derecha');

    // Calculate the number of pages based on the page size (6)
    const numeroPaginas = Math.ceil(peliculas.length / 6);
    let paginaActual = 0; // Variable para rastrear la página actual

    // Add event listener to the right arrow
    flechaDerecha.addEventListener('click', () => {
        if (paginaActual < numeroPaginas - 1) {
            paginaActual++;
            fila.scrollLeft = paginaActual * fila.offsetWidth;

            actualizarIndicadores();
        }
    });

    // Add event listener to the left arrow
    flechaIzquierda.addEventListener('click', () => {
        if (paginaActual > 0) {
            paginaActual--;
            fila.scrollLeft = paginaActual * fila.offsetWidth;

            actualizarIndicadores();
        }
    });

    // Function to update indicators based on current page
    function actualizarIndicadores() {
        const indicadores = document.querySelectorAll('.indicadores button');
        indicadores.forEach((indicador, index) => {
            if (index === paginaActual) {
                indicador.classList.add('activo');
            } else {
                indicador.classList.remove('activo');
            }
        });

        // Show/hide navigation arrows based on current page
        flechaDerecha.style.display = paginaActual < numeroPaginas - 1 ? 'block' : 'none';
        flechaIzquierda.style.display = paginaActual > 0 ? 'block' : 'none';
    }

    // Pagination indicators
    const numeroGrupos = Math.ceil(peliculas.length / 6);

    // Clear existing indicators before generating them again
    document.querySelector('.indicadores').innerHTML = '';

    for (let i = 0; i < numeroGrupos; i++) {
        const indicador = document.createElement('button');
        document.querySelector('.indicadores').appendChild(indicador);

        indicador.addEventListener('click', () => {
            paginaActual = i;
            fila.scrollLeft = paginaActual * fila.offsetWidth;
            actualizarIndicadores();
        });
    }

    // Initialize indicators and arrows
    actualizarIndicadores();
}

// Llamar a la función para establecer la paginación
establecerPaginacion();
