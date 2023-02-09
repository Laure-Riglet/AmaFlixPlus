document.addEventListener('DOMContentLoaded', () => {

    /***
     * Burger setup
     ***/

    // Get all "navbar-burger" elements
    const $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);

    // Add a click event on each of them
    $navbarBurgers.forEach(el => {
        el.addEventListener('click', () => {

            // Get the target from the "data-target" attribute
            const target = el.dataset.target;
            const $target = document.getElementById(target);

            // Toggle the "is-active" class on both the "navbar-burger" and the "navbar-menu"
            el.classList.toggle('is-active');
            $target.classList.toggle('is-active');
        });
    });

    /***
     * Navbar background when scrolling
     ***/ 

    // Get the "navbar" element
    const nav = document.querySelector('.navbar');
    
    // Ableing the background when leaving top of the page & removing background when back on top
    document.addEventListener("scroll", () => {
        if (window.pageYOffset === 0) {
            nav.classList.remove('scrolled');
            nav.classList.add('is-transparent');
        } else {
            nav.classList.add('scrolled');
            nav.classList.remove('is-transparent');
        }
    });
});