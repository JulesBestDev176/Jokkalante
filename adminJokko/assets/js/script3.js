document.addEventListener("DOMContentLoaded", () => {
  // Sélectionnez tous les liens dans la barre latérale
  const sideMenuLinks = document.querySelectorAll(".side-menu a");

  // Parcourez chaque lien pour ajouter un écouteur d'événements
  sideMenuLinks.forEach((link) => {
    link.addEventListener("click", (event) => {
      // Empêcher le comportement par défaut du lien
      event.preventDefault();

      // Supprimez la classe 'active' de tous les liens de la barre latérale
      sideMenuLinks.forEach((item) => {
        item.classList.remove("active");
      });

      // Supprimez la classe 'mainActive' de toutes les sections de contenu
      document.querySelectorAll("main").forEach((main) => {
        main.classList.remove("mainActive");
      });

      // Ajoutez la classe 'active' uniquement à l'élément de menu sur lequel vous avez cliqué
      link.classList.add("active");

      // Récupérez l'identifiant de la section de contenu correspondante à partir de l'attribut data-target
      const targetId = link.getAttribute("data-target");

      // Affichez la section de contenu correspondante en ajoutant la classe 'mainActive'
      document.getElementById(targetId).classList.add("mainActive");

      // Enregistrez l'identifiant de la section de contenu active dans le stockage local
      localStorage.setItem("activeSection", targetId);
    });
  });

  // Au chargement de la page, vérifiez s'il y a une section de contenu active dans le stockage local
  const activeSectionId = localStorage.getItem("activeSection");
  if (activeSectionId) {
    // Ajoutez la classe 'active' à l'élément de menu correspondant
    document
      .querySelector(`[data-target="${activeSectionId}"]`)
      .classList.add("active");

    // Ajoutez la classe 'mainActive' à la section de contenu correspondante
    document.getElementById(activeSectionId).classList.add("mainActive");
  }
});
