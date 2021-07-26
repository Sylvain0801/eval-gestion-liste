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

  const closeNewList = document.querySelector("#new-list [data-dismiss=dialog]");
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
  // Ferme les messages alert
  const alertClose = document.querySelectorAll("[data-dismiss=alert]");
  for (let close of alertClose) {
    close.addEventListener("click", function(e) {
        e.preventDefault()
        this.parentNode.style.display = 'none';
      });
    }
  
  // Darkmode
  const darkMode = () => {
    document.documentElement.style.setProperty('--color-primary-bg', '#323232')
    document.documentElement.style.setProperty('--color-secondary-bg', '#555555')
    document.documentElement.style.setProperty('--color-primary-writing', '#F1F1F1')
    document.documentElement.style.setProperty('--color-medium-writing', '#CCCCCC')
    document.documentElement.style.setProperty('--color-writing-hover', '#CCCCCC')
    document.documentElement.style.setProperty('--color-todo-border', '#888888')
    document.documentElement.style.setProperty('--color-input-bg', '#CCCCCC')
  }
  const ligthMode = () => {
    document.documentElement.style.setProperty('--color-primary-bg', 'white')
    document.documentElement.style.setProperty('--color-secondary-bg', '#F1F1F1')
    document.documentElement.style.setProperty('--color-primary-writing', '#323232')
    document.documentElement.style.setProperty('--color-medium-writing', '#555555')
    document.documentElement.style.setProperty('--color-writing-hover', '#555555')
    document.documentElement.style.setProperty('--color-todo-border', '#CCCCCC')
    document.documentElement.style.setProperty('--color-input-bg', '#FFFFFF')
  }
  const toggleDarkMode = document.getElementById('ball-darkmode')
  const theme = () => {
    if (localStorage.getItem('theme')) {
      darkMode()
      toggleDarkMode.setAttribute('checked', 'checked')
    } else {
      ligthMode()
      toggleDarkMode.removeAttribute('checked')
    }
  }
  toggleDarkMode.addEventListener('click', function() {
    if (this.checked) {
      localStorage.setItem('theme', 'darkmode')
      darkMode()
    } else {
      localStorage.removeItem('theme')
      ligthMode()
    }
  }) 
  theme()
};
