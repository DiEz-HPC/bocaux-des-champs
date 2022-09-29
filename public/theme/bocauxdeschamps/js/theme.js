/* Ce fichier est charger sur _master ( équivalent de base.html.twig ) */

document.addEventListener("DOMContentLoaded", function (event) {
  menuBurger();
});

function menuBurger() {
  const button = document.querySelector(".menu__mobile_button");
const navbar = document.querySelector(".navbar");
  button.addEventListener("click", () => {
    button.classList.toggle("active");
    navbar.classList.toggle("active");
  });
}
