document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('nav a').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const targetId = this.getAttribute('href').substring(1);
            const targetElement = document.getElementById(targetId);
            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    });

        // Funcion para cargar los juegos desde la API
        async function cargarJuegos() {
            try {
                const response = await fetch('api_videojuegos.php');
                const juegos = await response.json();
    
                const sectionGames = document.getElementById('games');
                sectionGames.innerHTML = '';  // Limpiar el contenido inicial
    
                juegos.forEach(juego => {
                    const juegoDiv = document.createElement('div');
                    juegoDiv.classList.add('game');
                    juegoDiv.dataset.anio = juego.lanzamiento;
    
                    // html para cada juego
                    juegoDiv.innerHTML = `
                        <img src="imagenes_juegos/${juego.imagen_url}" alt="${juego.titulo}">
                        <h2>${juego.titulo}</h2>
                        <p>${juego.descripcion}</p>
                        <p><strong>plataformas:</strong> ${juego.plataformas}</p>
                        <p><strong>lanzamiento:</strong> ${juego.lanzamiento}</p>
                    `;
    
                    sectionGames.appendChild(juegoDiv);
                });
            } catch (error) {
                console.error('Error al cargar los juegos:', error);
            }
        }
    
        // Llamar a cargarJuegos 
        cargarJuegos();
    });

    document.getElementById('filtroAnio').addEventListener('change', function () {
        const selectedYear = this.value;

        document.querySelectorAll('.game').forEach(juego => {
            const juegoAnio = juego.dataset.anio;

            if (selectedYear === 'todos' || juegoAnio === selectedYear) {
                juego.style.display = 'block';
            } else {
                juego.style.display = 'none';
            }
        });
    });


    const sectionGames = document.getElementById('games');
    const sectionOtrosJuegos = document.getElementById('otros-juegos');
    const sectionHome = document.getElementById('home');


    sectionOtrosJuegos.style.display = 'none';


    const otrosJuegosLink = document.querySelector('nav a[href="#otros-juegos"]');
    if (otrosJuegosLink) {
        otrosJuegosLink.addEventListener('click', function (e) {
            e.preventDefault();

            sectionOtrosJuegos.style.display = 'block';

            sectionGames.style.display = 'none';

            sectionHome.style.display = 'none';
        });
    }


    const inicioLink = document.querySelector('nav a[href="#home"]');
    if (inicioLink) {
        inicioLink.addEventListener('click', function (e) {
            e.preventDefault();

            sectionHome.style.display = 'block';

            sectionGames.style.display = 'none';

            sectionOtrosJuegos.style.display = 'none';
        });
    }


    const juegosLink = document.querySelector('nav a[href="#games"]');
    if (juegosLink) {
        juegosLink.addEventListener('click', function (e) {
            e.preventDefault();

            sectionGames.style.display = 'block';

            sectionOtrosJuegos.style.display = 'none';

            sectionHome.style.display = 'none';
        });
    }