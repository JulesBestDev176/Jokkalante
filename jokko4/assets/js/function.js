let inscrire = document.getElementById("inscrire");
let connecter = document.getElementById("connecter");
let passwordUp = document.getElementById("passwordUp");
let passwordIn = document.getElementById("passwordIn");
let email = document.getElementById("email");
let prenom = document.getElementById("prenom");
let nom = document.getElementById("nom");

function verifierEmail(email) {
  var regexEmail = /^[a-zA-Z0-9._-]+@gmail\.com$/;
  if (email.length > 255) {
    return false;
  }
  if (!regexEmail.test(email)) {
    return false;
  }
  return true;
}

function verifierMDP(motDePasse) {
  var regexMDP = /^(?=.*[a-zA-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
  if (!regexMDP.test(motDePasse)) {
    return false;
  }
  return true;
}

function verifNom(nom) {
  var regexNom = /^[a-zA-Z]{2,}$/;
  if (!regexNom.test(nom)) {
    return false;
  }
  return true;
}

function verifPrenom(prenom) {
  var regexPrenom = /^[a-zA-Z]{3,}$/;
  if (!regexPrenom.test(prenom)) {
    return false;
  }
  return true;
}

email.addEventListener("input", function () {
  if (!verifierEmail(email.value)) {
    inscrire.disabled = true;
  } else {
    inscrire.disabled = false;
  }
});

passwordUp.addEventListener("input", function () {
  if (!verifierMDP(passwordUp.value)) {
    inscrire.disabled = true;
  } else {
    inscrire.disabled = false;
  }
});

nom.addEventListener("input", function () {
  if (!verifNom(nom.value)) {
    inscrire.disabled = true;
  } else {
    inscrire.disabled = false;
  }
});

prenom.addEventListener("input", function () {
  if (!verifPrenom(nom.value)) {
    inscrire.disabled = true;
  } else {
    inscrire.disabled = false;
  }
});

passwordIn.addEventListener("input", function () {
  if (!verifierMDP(passwordIn.value)) {
    connecter.disabled = true;
  } else {
    connecter.disabled = false;
  }
});
