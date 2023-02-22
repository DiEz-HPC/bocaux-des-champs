document.addEventListener("DOMContentLoaded", () => {
  handleLessButton();
  handleMoreButton();
  handleClearProductButton();
});

const handleLessButton = () => {
  lessButton = document.querySelectorAll("#less_button");
  lessButton.forEach(function (button) {
    button.addEventListener("click", function (e) {
      decreaseQty(this);
    });
  });
};

const decreaseQty = (button) => {
  let productId = button.dataset.productid;
  let quantity = document.querySelector("#qty-" + productId);
  let value = parseInt(quantity.innerText);
  if (value > 1) {
    quantity.innerText = value - 1;
  } else {
    let item = document.getElementById("productLine-" + productId);
    item.remove();
  }
  updateTotalItems();
};

const handleMoreButton = () => {
  moreButton = document.querySelectorAll("#more_button");
  moreButton.forEach(function (button) {
    button.addEventListener("click", function (e) {
      increaseQty(this);
    });
  });
};

const increaseQty = (button) => {
  let productId = button.dataset.productid;
  let quantity = document.querySelector("#qty-" + productId);
  let value = parseInt(quantity.innerText);
  quantity.innerText = value + 1;
  updateTotalItems();
};

const handleClearProductButton = () => {
  clearButton = document.querySelectorAll("#remove_button");
  clearButton.forEach(function (button) {
    button.addEventListener("click", function (e) {
      clearQty(this);
    });
  });
};

const clearQty = (button) => {
  let productId = button.dataset.productid;
  let item = document.getElementById("productLine-" + productId);
  item.remove();
  updateTotalItems();
};

const updateTotalItems = () => {
  const cartTotal = document.querySelectorAll("#cart_qty");
  const totalItems = document.querySelector("#totalQuantity");
  const singleProductQty = document.querySelectorAll(".singleProductQty");
  let total = 0;
  singleProductQty.forEach((item) => {
    total += parseInt(item.innerText);
  });
  totalItems.innerHTML = total;
  cartTotal.forEach((cart) => {
    cart.innerHTML = total;
  });
};
