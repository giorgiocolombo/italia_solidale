document.addEventListener("DOMContentLoaded", () => {
  const hamburger = document.querySelector(".hamburger");
  const nav = document.querySelector("nav");

  const openMenu = () => {
    nav.classList.add("nav_open");
    hamburger.classList.add("ham_open");
  };
  const closeMenu = () => {
    nav.classList.remove("nav_open");
    hamburger.classList.remove("ham_open");
  };

  hamburger.addEventListener("click", () => {
    nav.classList.contains("nav_open") ? closeMenu() : openMenu();
  });
});
