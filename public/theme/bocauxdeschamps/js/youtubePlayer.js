var modals = document.querySelectorAll(".modalYoutube");
// Fonction on change la source de la vidéo afin de la stopper lorsque la modal est fermé. 
modals.forEach(function (modal) {
  modal.addEventListener("hidden.bs.modal", function (event) {
    var videoPlayer = modal.querySelector("iframe");
    videoPlayer.src = videoPlayer.src;
  });
});
