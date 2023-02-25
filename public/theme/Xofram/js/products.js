document.addEventListener("DOMContentLoaded", function () {
  const cardAddToCart = document.querySelectorAll(".productCard__btn");
  const cartTotal = document.querySelectorAll("#cart_qty");

  cardAddToCart.forEach((btn) => {
    var productId = btn.dataset.product;
    btn.addEventListener("click", function (e) {
      var quantity = cartTotal.innerText;
      var value = parseInt(quantity);

      cartTotal.innerText = value + 1;
      // request to add to cart to url /card/{id}
      $.ajax({
        url: "/cart/add/" + productId,
        type: "POST",
        data: {
          quantity: 1,
        },
        success: function (response) {
          // On notifie le client que le produit a bien été ajouté au panier
          $(btn).notify("Produit ajouté au panier", {
            position: "top",
            className: "success",
          });
          // On met à jour le nombre de produits dans le panier
          response = JSON.parse(response);
          let totalQuantity = 0;
          for (let key in response) {
            if (!isNaN(response[key])) {
              totalQuantity += parseInt(response[key]);
            }
          }
          cartTotal.forEach((cart) => {
            cart.innerHTML = totalQuantity;
          });
        },
      });
    });
  });
});

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
