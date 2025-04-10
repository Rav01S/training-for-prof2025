// SideBar
const sidebar = document.querySelector('aside.sidebar');
const burgerBtn = document.querySelector('.header__burger')

sidebar.addEventListener('click', () => {
  sidebar.classList.toggle('active');
})
burgerBtn.addEventListener('click', () => {
  sidebar.classList.toggle('active');
})