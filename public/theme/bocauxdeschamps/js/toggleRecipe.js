window.onload = function () {
  var recipeContainer = document.getElementById("recipeContainer");
  var nutritionalContainer = document.getElementById("nutritionalContainer");
  var buttons = [document.getElementById("recipeBtn"), document.getElementById("nutritionalBtn")];

  buttons.forEach(function (button) {
    button.addEventListener("click", function () {
      if (button.id === "recipeBtn") {
        toggleStyle(recipeContainer, nutritionalContainer);
        toggleClassname(buttons, "active");
      } else {
        toggleStyle(nutritionalContainer, recipeContainer);
        toggleClassname(buttons, "active");
      }
    });
  });
};

function toggleClassname(elements, classname) {
  for (var i = 0; i < elements.length; i++) {
    elements[i].classList.toggle(classname);
  }
}

function toggleStyle(elementVisible, elementHidden) {
  elementVisible.style.visibility = "visible";
  elementVisible.style.height = "auto";
  elementHidden.style.visibility = "hidden";
  elementHidden.style.height = "0";
}
