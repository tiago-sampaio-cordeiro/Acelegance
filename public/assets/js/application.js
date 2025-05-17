document.addEventListener("DOMContentLoaded", function () {
  const button = document.getElementById("user-menu-button");
  const menu = document.getElementById("user-dropdown");

  button.addEventListener("click", function () {
    menu.classList.toggle("hidden");
  });
});
