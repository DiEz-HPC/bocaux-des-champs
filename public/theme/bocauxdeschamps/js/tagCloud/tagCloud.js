window.addEventListener("DOMContentLoaded", function () {
  setRandomColor();
});

const tagBadges = document.querySelectorAll(".tagBadge");
const cssVariables = [
  "--primary-color",
  "--secondary-color",
  "--tertiary-color",
  "--quaternary-color",
];

var selectedColor = [];

const setRandomColor = () => {
  tagBadges.forEach((tagBadge) => {
    var randomNumber = Math.floor(Math.random() * cssVariables.length);
    // On récupère une couleurs au hasard dans le tableau cssVariables.
    var randomColor = cssVariables[randomNumber];
    // Si la couleur est la même que la précédente, on en prend une autre.
    if (randomColor == selectedColor[selectedColor.length - 1]) {
        setRandomColor();
    }
    tagBadge.style.backgroundColor = getCssVariable(randomColor);
    selectedColor.push(randomColor);
  });
};

const getCssVariable = (variable) => {
  return getComputedStyle(document.documentElement).getPropertyValue(variable);
};
