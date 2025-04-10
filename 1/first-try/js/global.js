// SideBar
const sidebar = document.querySelector("aside");
const burgerBtn = document.querySelector(".header__burger-menu");

burgerBtn.addEventListener("click", () => {
  sidebar.classList.toggle("aside_active");
});

sidebar.addEventListener("click", () => {
  sidebar.classList.toggle("aside_active");
});