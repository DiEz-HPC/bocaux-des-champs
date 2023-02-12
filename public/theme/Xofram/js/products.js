const htmxResult = document.getElementById("htmx-results");

htmxResult.addEventListener("htmx:afterSwap", function (event) {
  handleTabChange();
  addTotalItems();
});

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

const handleTabChange = () => {
  const selectors = [
    document.querySelector("#recipeSelector"),
    document.querySelector("#nutritionalSelector"),
  ];

  selectors.forEach((selector) => {
    selector.addEventListener("click", function (e) {
      if (selector.classList.contains("active")) {
        return;
      }
      
      displaySelectorContent(selector);
      selectors.forEach((selector) => {
        selector.classList.toggle("active");
      });
    });
  });
};

const displaySelectorContent = (selector) => {
  const tabs = [
    document.querySelector("#recipeContainer"),
    document.querySelector("#nutritionalContainer"),
  ];
  let dataTab = selector.dataset.tab;
  tabs.forEach((tab) => {
    if (dataTab + "Container" === tab.id) {
      tab.classList.remove("d-none");
    } else {
      tab.classList.add("d-none");
    }
  });
};
