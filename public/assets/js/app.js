window.onload = () => {
  const createList = document.querySelector(".add-new-list");
  const newList = document.getElementById("new-list");

  // Affiche une fenêtre pour créer une nouvelle liste
  createList.addEventListener("click", (e) => {
    e.preventDefault();
    newList.classList.add("show");
  });

  const btnEdit = document.querySelectorAll(".show.fa.fa-pencil");
  // Edite le titre de la liste
  for (const btn of btnEdit) {
    btn.addEventListener("click", function (e) {
      e.preventDefault();
      const parent = this.parentNode;
      parent.children[1].classList.add("show");
      parent.children[2].classList.remove("show");
      parent.parentNode.children[1].classList.add("show");
      parent.parentNode.children[0].classList.remove("show");
      this.remove("show");
    });
  }

  const closeNewList = document.querySelector(
    "#new-list [data-dismiss=dialog]"
  );
  // Ferme la fenêtre pour créer une nouvelle liste
  closeNewList.addEventListener("click", (e) => {
    e.preventDefault();
    newList.classList.remove("show");
  });

  // Gestion des modales
  const modalButtons = document.querySelectorAll("[data-toggle=modal]");

  for (let button of modalButtons) {
    button.addEventListener("click", function (e) {
      e.preventDefault();
      // On récupère le data-target
      let target = this.dataset.target;
      
      // On récupère la bonne modale
      let modal = document.querySelector(target);
      console.log(modal);

      // On affiche la modale
      setTimeout(() => modal.classList.add("show"), 200);

      // On récupère les boutons de fermeture
      const modalClose = modal.querySelectorAll("[data-dismiss=dialog]");

      for (let close of modalClose) {
        close.addEventListener("click", () => {
          modal.classList.remove("show");
        });
      }

      // On gère la fermeture lors du clic sur la zone grise
      modal.addEventListener("click", function () {
        this.classList.remove("show");
      });
      // On évite la propagation du clic d'un enfant à son parent
      modal.children[0].addEventListener("click", function (e) {
        e.stopPropagation();
      });
    });
  }

  // Button radio status
  const btnRadioStatus = document.querySelectorAll('span.custom-input-radio')
  for (const btnRadio of btnRadioStatus) {
    btnRadio.addEventListener('click', function(e) {
      e.stopPropagation()
      for (const btnRadio of btnRadioStatus) {
        if (btnRadio != this) {
          btnRadio.classList.remove('checked')
          document.getElementById('todo_status_' + btnRadio.dataset.id).removeAttribute('checked')
        }
      }
      this.classList.add('checked')
      document.getElementById('todo_status_' + this.dataset.id).setAttribute('checked', 'checked')
    })
  }
};