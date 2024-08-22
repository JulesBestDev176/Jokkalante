// JavaScript file
document.addEventListener("DOMContentLoaded", function () {
  // Sélectionnez le bouton "Like"
  const likeButton = document.querySelector(".like_btn");

  // Ajoutez un gestionnaire d'événements pour le clic sur le bouton "Like"
  likeButton.addEventListener("click", function (event) {
    event.preventDefault(); // Empêche le comportement par défaut du lien

    // Récupérez l'ID du post à partir de l'attribut data-postid du bouton "Like"
    const postId = likeButton.dataset.postid;

    // Envoyez une requête AJAX au serveur
    const xhr = new XMLHttpRequest();
    xhr.open("GET", `?page=like&t=1&idPost=${postId}`);
    xhr.onreadystatechange = function () {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          // La requête a réussi
          const response = JSON.parse(xhr.responseText);

          // Mettez à jour la classe du bouton "Like" en fonction de la réponse du serveur
          if (response.liked) {
            likeButton.classList.add("liked");
          } else {
            likeButton.classList.remove("liked");
          }
        } else {
          // La requête a échoué
          console.error("Erreur lors de la requête AJAX : " + xhr.status);
        }
      }
    };
    xhr.send();
  });
});
