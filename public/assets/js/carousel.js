document.addEventListener("DOMContentLoaded", () => {
  const carousel = document.getElementById("autoCarousel");
  let scrollAmount = 0;
  const scrollStep = 300;
  const scrollInterval = 3000;

  setInterval(() => {
    if (carousel.scrollLeft + carousel.clientWidth >= carousel.scrollWidth) {
      scrollAmount = 0;
    } else {
      scrollAmount += scrollStep;
    }

    carousel.scrollTo({
      left: scrollAmount,
      behavior: "smooth",
    });
  }, scrollInterval);
});
