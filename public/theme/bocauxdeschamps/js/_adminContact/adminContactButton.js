document.addEventListener("DOMContentLoaded", function () {
  validateDelete();
  replyToMessage();
  closeModal();
  formAlreadySend();
});

const deleteButton = document.querySelectorAll(".deleteButton");
const feedbackMessage = document.querySelector(".boltforms-feedback");
const replyButton = document.querySelectorAll(".replyButton");
const modal = document.querySelector(".replyModal");
const form = document.querySelector("#replyForm");

const validateDelete = () => {
  deleteButton.forEach((button) => {
    button.addEventListener("click", (e) => {
      e.preventDefault();
      if (confirm("Voulez-vous vraiment supprimer ce contact ?")) {
        button.parentNode.submit();
      }
    });
  });
};

const replyToMessage = () => {
  replyButton.forEach((button) => {
    button.addEventListener("click", (e) => {
      e.preventDefault();
      modal.classList.toggle("hidden");
      fillModal(e.target);
      clearFeedback();
    });
  });
};

const fillModal = (e) => {
  const email = document.querySelector("#reply_email");
  const subject = document.querySelector("#reply_subject");
  const message = document.querySelector("#reply_message");
  email.value = e.dataset.email;
  subject.value = "";
  message.value = "";
};

const closeModal = () => {
  const closeButton = document.querySelector("#close_modal");
  closeButton.addEventListener("click", (e) => {
    e.preventDefault();
    modal.classList.toggle("hidden");
  });
};

const formAlreadySend = () => {
  if (feedbackMessage) {
    modal.classList.toggle("hidden");
  }
};

const clearFeedback = () => {
  if (feedbackMessage) {
    feedbackMessage.remove();
  }
};
