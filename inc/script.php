<script>
    document.addEventListener('DOMContentLoaded', () => {

    // Get all "navbar-burger" elements
    // Obtener todos los elementos "navbar-burger"
    const $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);

    // Add a click event on each of them
    // Agregar un evento de clic en cada uno de ello
    $navbarBurgers.forEach( el => {
    el.addEventListener('click', () => {

        // Get the target from the "data-target" attribute
        // obtenga el destino del atributo "data-target" "Objetivo de datos"
        const target = el.dataset.target;
        const $target = document.getElementById(target);

        // Toggle the "is-active" class on both the "navbar-burger" and the "navbar-menu"
        // Cambia la clase "is-active" tanto en "navbar-burger" como en "navbar-menu"
        el.classList.toggle('is-active');
        $target.classList.toggle('is-active');

    });
    });

    });
</script>
<script> src="./js/ajax.js"</script>