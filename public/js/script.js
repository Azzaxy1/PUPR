window.addEventListener("scroll", function () {
    const navbar = document.getElementById("mainNavbar");
    if (window.scrollY > 50) {
        navbar.style.boxShadow = "0px 6px 15px rgba(0, 0, 0, 0.2)"; // Shadow lebih besar
    } else {
        navbar.style.boxShadow = "0px 4px 10px rgba(0, 0, 0, 0.1)"; // Shadow default
    }
});
