/**
 * Comment l'utiliser ?
 *
 * 1. Créer un composant qui contient cette structure:
 *
 *  <div id="diez-modal-overlay">
 *      <div id="diez-modal">
 *          <div id="diez-modal-header">
 *              <div class="text-center"> Message de John Doe</div>
 *              <div id="diez-modal-close">X</div>
 *          </div>
 *          <div id="diez-modal-content">Lorem ipsum dolor sit amet</div>
 *      </div>
 * </div>
 *
 * 2. Créer un bouton qui ouvre la modal:
 *
 *      <button id="diez-modal-open">Ouvrir la modal</button>
 *
 * 3. Créer un fichier js qui contient le code suivant:
 *
 *      const handleModal = () => {
 *          const modal = new Modal();
 *      }
 *
 **/

class Modal {
  constructor() {
    this.modalOpen = document.querySelectorAll("#diez-modal-open");
    this.bodyOverlay = document.getElementById("diez-modal-overlay");
    this.modal = document.getElementById("diez-modal");
    this.init();
  }

  init() {
    this.handleInnerElements();
    this.setDisplayStyle();
    this.handleOpenButtons();
    this.checkForContentChange();
  }

  handleInnerElements() {
    this.modalHeader = document.getElementById("diez-modal-header");
    this.modalClose = document.getElementById("diez-modal-close");
    this.modalContent = document.getElementById("diez-modal-content");

    this.modalClose.addEventListener("click", () => {
      this.close();
    });
  }

  handleOpenButtons() {
    for (let i = 0; i < this.modalOpen.length; i++) {
      this.modalOpen[i].addEventListener("click", () => {
        this.open();
      });
    }
  }

  handleClickOutside() {
    window.addEventListener("click", (e) => {
      if (e.target == this.bodyOverlay) {
        this.close();
      }
    });
  }

  checkForContentChange() {
    const observer = new MutationObserver((mutations) => {
      mutations.forEach((mutation) => {
        if (mutation.type == "attributes") {
          this.handleInnerElements();
          this.setBaseStyle();
        }
      });
    });

    observer.observe(this.modal, {
      attributes: true,
      childList: true,
    });
  }

  open() {
    this.modal.style.display = "block";
    this.bodyOverlay.style.display = "block";
    this.handleClickOutside();
  }

  close() {
    this.modal.style.display = "none";
    this.bodyOverlay.style.display = "none";
  }

  setBaseStyle() {
    this.bodyOverlay.style.position = "fixed";
    this.bodyOverlay.style.width = "100vw";
    this.bodyOverlay.style.height = "100vh";
    this.bodyOverlay.style.top = "0";
    this.bodyOverlay.style.left = "0";
    this.bodyOverlay.style.zIndex = "100";
    this.bodyOverlay.style.backgroundColor = "rgba(0, 0, 0, 0.5)";
    this.bodyOverlay.style.overflow = 'scroll';

    this.modal.style.position = "fixed";
    this.modal.style.width = "60vw";
    this.modal.style.minHeight = "40vh";
    this.modal.style.transform = "translate(-50%, -50%)";
    this.modal.style.top = "50%";
    this.modal.style.left = "50%";
    this.modal.style.backgroundColor = "#fff";
    this.modal.style.overflow = 'scroll';

    this.modalHeader.style.position = "relative";
    this.modalHeader.style.minHeight = "3.5rem";
    this.modalHeader.style.backgroundColor = "#f8f9fa";
    this.modalHeader.style.borderBottom = "1px solid #dee2e6";

    this.modalClose.style.position = "absolute";
    this.modalClose.style.top = "0";
    this.modalClose.style.right = "0";
    this.modalClose.style.cursor = "pointer";
    this.modalClose.style.fontWeight = "bold";
    this.modalClose.style.color = "#000";
    let svg = this.modalClose.querySelector("svg");
    if (svg) {
      svg.style.width = "1.5rem";
      svg.style.height = "1.5rem";
      svg.style.margin = "0.75rem";
    }
    this.modalContent.style.padding = "1rem";
    this.modalContent.style.overflow = 'scroll';
    this.modalContent.style.maxHeight = '75vh';
  }

  setDisplayStyle() {
    this.bodyOverlay.style.display = "none";
    this.modal.style.display = "none";
    this.setBaseStyle();
  }
}
