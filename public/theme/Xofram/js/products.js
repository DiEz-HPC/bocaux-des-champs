const htmxResult = document.getElementById("htmx-results");

htmxResult.addEventListener("htmx:afterSwap", function (event) {
  const tabsSelector = document.getElementById("tabsSelector");
 addTotalItems(); 
  if (tabsSelector.children.length > 0) {
    // On boucle sur les tabs
    for (let i = 0; i < tabsSelector.children.length; i++) {
      // On ajoute un event listener sur chaque tab
      tabsSelector.children[i].addEventListener("click", function () {
        // On récupère le data-tab de la tab
        displayTabContent(tabsSelector.children[i].getAttribute("data-tab"));
        toggleActiveClass(tabsSelector.children[i]);
      });
    }
  }
});

const displayTabContent = (dataTab) => {
  var contentContainer = document.getElementById("contentContainer");
  // On récupère le container correspondant
  var tabContent = contentContainer.querySelector("#" + dataTab + "Container");
  // On l'affiche
  tabContent.classList.remove("d-none");
  // On cache les autres
  for (let j = 0; j < contentContainer.children.length; j++) {
    if (contentContainer.children[j] !== tabContent) {
      contentContainer.children[j].classList.add("d-none");
    }
  }
};
const toggleActiveClass = (element) => {
  var activeElements = document.getElementsByClassName("active");
  for (let i = 0; i < activeElements.length; i++) {
    activeElements[i].classList.remove("active");
  }
  element.classList.add("active");
};

const addTotalItems = () => {
    const btnAdd = document.querySelector("#btnAddToCart");
    const cartTotal = document.querySelector("#cart_qty");
    const selectedQty = document.querySelector("#quantitySelector");

    btnAdd.addEventListener("click", function (e) {
        let quantity = cartTotal.innerText;
        let value = parseInt(quantity);
        cartTotal.innerText = value + parseInt(selectedQty.value);

    });

};