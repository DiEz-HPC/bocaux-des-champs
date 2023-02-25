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
      updateItemPrice(this);
      updateTotalPrice();
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
      updateItemPrice(this);
      updateTotalPrice();
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
      updateTotalPrice();
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
  const totalItems = document.querySelectorAll("#totalQuantity");
  const singleProductQty = document.querySelectorAll(".singleProductQty");
  let total = 0;
  singleProductQty.forEach((item) => {
    total += parseInt(item.innerText);
  });
  totalItems.forEach((totalItem) => {
  totalItem.innerHTML = total;
  });
  cartTotal.forEach((cart) => {
    cart.innerHTML = total;
  });

  if(total > 1){
    document.getElementById("articleWord").innerHTML = "articles";
  }else {
    document.getElementById("articleWord").innerHTML = "article";
  }
};

const updateItemPrice = (button) => {
    let productId = button.dataset.productid;
    let quantityItem = document.querySelector("#qty-" + productId);
    if(quantityItem){
    let quantityValue = parseInt(quantityItem.innerText);
    let priceItem = document.querySelector("#productPrice-" + productId);
    let priceValue = parseInt(priceItem.dataset.productprice);
    let totalItemsPrice = quantityValue * priceValue;
    priceItem.innerHTML = totalItemsPrice + " €";
    }
}

const updateTotalPrice = () => {
    const totalPrice = document.querySelector("#totalPrice");
    const singleProductPrice = document.querySelectorAll(".singleProductPrice");
    let total = 0;
    singleProductPrice.forEach((item) => {
        total += parseInt(item.innerText);
    });
    totalPrice.innerHTML = total + " €";
}