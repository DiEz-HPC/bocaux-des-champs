document.addEventListener("DOMContentLoaded", function () {
  this.getElementById("qrCode__selectAll").addEventListener(
    "click",
    function () {
      var checkboxes = document.getElementsByClassName("qrCode__checkbox");
      for (var i = 0; i < checkboxes.length; i++) {
        if (this.clicked == false || this.clicked == undefined) {
          checkboxes[i].checked = true;
        } else {
          checkboxes[i].checked = false;
        }
      }
      this.clicked = !this.clicked;
    }
  );

  var formTr = this.getElementsByClassName("formTr");
  for (var i = 0; i < formTr.length; i++) {
    formTr[i].addEventListener("click", function () {
      var id = this.getAttribute("data-id");
      var checkbox = document.getElementsByClassName("qrCode__checkbox_index" + id);
      checkbox[0].checked = !checkbox[0].checked;
    });
  }
});
