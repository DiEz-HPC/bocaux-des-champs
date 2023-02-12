document.addEventListener("DOMContentLoaded", function () {
    selectAllCheckbox();
    selectCheckboxOnRowClick()
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
      button.innerHTML = "Aucun contenu sélectionné";
    } else if (count == 1) {
      button.disabled = false;
      button.innerHTML = "Générer le QR Code";
    } else {
      button.disabled = false;
      button.innerHTML = "Générer " + count + " QR Codes";
    }
  }