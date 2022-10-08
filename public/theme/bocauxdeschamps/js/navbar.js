window.addEventListener("DOMContentLoaded", () => {
menuBurger();
});


const navbar = document.getElementById("navbar");
const main = document.getElementById("mainContent");
const button = document.querySelector(".menu__mobile_button");
const body = document.querySelector("body");

const menuBurger = () => {
    // If button is clicked toggle active class on navbar
    button.addEventListener("click", () => {
      button.classList.toggle("active");
      navbar.classList.toggle("active");
      body.style.overflow = body.style.overflow === "hidden" ? "auto" : "hidden";
      main.style.transition="filter 0.5s ease-in-out";
      main.style.filter === "brightness(45%)" ? main.style.filter="none" : main.style.filter="brightness(45%)";
      // If user clicks outside of navbar, close it, remove active class and remove active style
      main.addEventListener("click", () => {
        button.classList.remove("active");
        navbar.classList.remove("active");
        body.style.overflow = "auto";
        main.style.filter="none";
      });
    });
  }
  
