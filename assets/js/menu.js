function toggleMenu() {
    const menu = document.getElementById("sidebar");
    menu.classList.toggle("open");

    // Esto mueve toda la página
    document.body.classList.toggle("menu-open");
}
