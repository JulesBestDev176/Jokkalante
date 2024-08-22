let connecter = document.getElementById("connecter");
let passwordIn = document.getElementById("passwordIn");

function verifierMDP(motDePasse) {
  var regexMDP = /^(?=.*[a-zA-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
  if (!regexMDP.test(motDePasse)) {
    return false;
  }
  return true;
}

passwordIn.addEventListener("input", function () {
  if (!verifierMDP(passwordIn.value)) {
    connecter.disabled = true;
  } else {
    connecter.disabled = false;
  }
});
