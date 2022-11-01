document.addEventListener("DOMContentLoaded", function () {
  settingToggle();
  editPreview();

const allRanges = document.querySelectorAll(".range-wrap");
allRanges.forEach((wrap) => {
  const range = wrap.querySelector(".range");
  const bubble = wrap.querySelector(".bubble");

  range.addEventListener("input", () => {
    setBubble(range, bubble);
  });
  setBubble(range, bubble);
});
});

function settingToggle() {
  document
    .getElementById("qrCode__setting_toggler")
    .addEventListener("click", function () {
      var container = document.getElementById("qrCode__setting_container");
      if (container.style.display == "none") {
        container.style.display = "block";
      } else {
        container.style.display = "none";
      }
    });
}


function setBubble(range, bubble) {
    console.log(range.value);
  const val = range.value;
  const min = range.min ? range.min : 0;
  const max = range.max ? range.max : 100;
  const newVal = Number(((val - min) * 100) / (max - min));
  bubble.innerHTML = val;

  // Sorta magic numbers based on size of the native UI thumb
  bubble.style.left = `calc(${newVal}% + (${8 - newVal * 0.15}px))`;
}

function editPreview() {
  var preview = document.getElementById("qrCode__preview");
  document.getElementById("qrCodeSize").addEventListener("click", function () {
    preview.style.width = this.value + "px";
  });
  document
    .getElementById("qrCodeMargin")
    .addEventListener("click", function () {
      preview.style.padding = this.value + "px";
    });
}
