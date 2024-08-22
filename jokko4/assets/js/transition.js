const nouveauCompte = document.getElementById("nouveauCompte");
const quitter = document.getElementById("quitter");
const inscription = document.querySelector(".inscription");

nouveauCompte.addEventListener("click", (e) => {
  e.preventDefault();
  inscription.classList.add("active");
});
quitter.addEventListener("click", (e) => {
  e.preventDefault();
  inscription.classList.remove("active");
});
