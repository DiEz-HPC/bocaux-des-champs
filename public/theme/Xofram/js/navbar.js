document.addEventListener("DOMContentLoaded", function () {
  const navToggler = document.querySelector(".navbar-toggler");
  navToggler.addEventListener("click", function () {
    const navMenu = document.querySelector("#navbarNavAltMarkup");
    const icon = navToggler.querySelector("i");
    navMenu.classList.toggle("show");
    if(navMenu.classList.contains("show")) {
        icon.classList.remove("fa-bars");
        icon.classList.add("fa-xmark");
    }else{
        icon.classList.remove("fa-xmark");
        icon.classList.add("fa-bars");
    }
  });
});
