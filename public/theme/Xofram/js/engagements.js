document.addEventListener("DOMContentLoaded", function () {
  console.log("DOM fully loaded and parsed");
  handleCards();
});

const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.classList.add("animate__fadeInUp");
        observer.unobserve(entry.target);
      }
    });
  });

const handleCards = () => {
  const cards = document.querySelectorAll(".outer_engagement_card");
  cards.forEach((card) => {
    let logo = card.querySelector(".icon_1");
    
    observer.observe(card, logo);
  });
};


