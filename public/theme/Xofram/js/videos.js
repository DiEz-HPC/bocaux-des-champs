const modal = document.querySelector("#staticBackdrop");
modal.addEventListener("hidden.bs.modal", function (event) {
  var videoPlayer = modal.querySelector("iframe");
  if (videoPlayer) {
    videoPlayer.src = videoPlayer.src;
  }
});
