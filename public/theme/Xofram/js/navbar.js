document.addEventListener("DOMContentLoaded", function () {
  const navToggler = document.querySelector(".navbar-toggler");
  navToggler.addEventListener("click", function () {
    const navMenu = document.querySelector("#navbarNavAltMarkup");
    navMenu.classList.toggle("show");
  });
});
