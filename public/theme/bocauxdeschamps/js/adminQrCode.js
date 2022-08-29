document.addEventListener("DOMContentLoaded", function () {
  selectAllCheckbox();
  selectCheckboxOnRowClick();
  changeButton();
  settingToggle();
});

function selectAllCheckbox() {
  var checkboxes = document.getElementsByClassName("qrCode__checkbox");
  document
    .getElementById("qrCode__selectAll")
    .addEventListener("click", function () {
      for (var i = 0; i < checkboxes.length; i++) {
        if (this.clicked == false || this.clicked == undefined) {
          checkboxes[i].checked = true;
        } else {
          checkboxes[i].checked = false;
        }
      }
      this.clicked = !this.clicked;
      changeButton();
    });
}

function selectCheckboxOnRowClick() {
  var formTr = document.getElementsByClassName("formTr");
  for (var i = 0; i < formTr.length; i++) {
    formTr[i].addEventListener("click", function () {
      var id = this.getAttribute("data-id");
      var checkbox = document.getElementsByClassName(
        "qrCode__checkbox_index" + id
      );
      checkbox[0].checked = !checkbox[0].checked;
      changeButton();
    });
  }
}

function checkCount() {
  var checkboxes = document.getElementsByClassName("qrCode__checkbox");
  var count = 0;
  for (var i = 0; i < checkboxes.length; i++) {
    if (checkboxes[i].checked) {
      count++;
    }
  }
  return count;
}

function changeButton() {
  var button = document.getElementById("qrCode__sendButton");
  button.innerHTML = "Générer (" + checkCount() + ") QR Code(s)";
  var count = checkCount();
  if (count == 0) {
    button.disabled = true;
    button.innerHTML = "Aucune vidéo sélectionné";
  } else if (count == 1) {
    button.disabled = false;
    button.innerHTML = "Générer le QR Code";
  } else {
    button.disabled = false;
    button.innerHTML = "Générer " + count + " QR Codes";
  }
}


function settingToggle(){
    document.getElementById('qrCode__setting_toggler').addEventListener('click', function(){
        var container = document.getElementById('qrCode__setting_container');
        if(container.style.display == 'none'){
            container.style.display = 'block';
        }else{
            container.style.display = 'none';
        }
    })
}

const allRanges = document.querySelectorAll(".range-wrap");
allRanges.forEach(wrap => {
  const range = wrap.querySelector(".range");
  const bubble = wrap.querySelector(".bubble");

  range.addEventListener("input", () => {
    setBubble(range, bubble);
  });
  setBubble(range, bubble);
});

function setBubble(range, bubble) {
  const val = range.value;
  const min = range.min ? range.min : 0;
  const max = range.max ? range.max : 100;
  const newVal = Number(((val - min) * 100) / (max - min));
  bubble.innerHTML = val;

  // Sorta magic numbers based on size of the native UI thumb
  bubble.style.left = `calc(${newVal}% + (${8 - newVal * 0.15}px))`;
}
