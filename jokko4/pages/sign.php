<?php
  
  if(isset($_GET['emailExist'])) {
      $activeClass = "active";
      unset($_GET);
      
    

    
  }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <link rel="stylesheet" href="./assets/css/style.css">
    
    
</head>
<body>
  <section class="container">
        <div class="title">
            <h1>Jookalante</h1>
            <p>Explorez vos passions et connectez-vous avec des esprits<br> similaires à travers le monde sur Jookalante,<br> le réseau social qui célèbre la diversité  des passions!</p>
        </div>
        <form class="formulaire" method="post" action="index.php">
          <div class="form-control">
            <input type="text" name="username" id="username" autocomplete="username">
            <label class="labs" for="username">Nom d'utilisateur</label>
          </div>
          <div class="form-control">
            <input type="password" id="passwordIn" name="password" >
            <label class="labs" for="passwordIn">Mot de passe</label>
          </div>
          <div class="form-control">
            <?php 
              showError("log");
              unset($_SESSION['error']);
            ;?>
          </div>
          <input type="submit" id="connecter" name="connecter" value="Se connecter" class="btn-submit btn">
          <a class="mdp-oublie" href="index.php?forget">Mot de passe oublié ?</a>
          <hr>
          <a href="" id="nouveauCompte" class="btn-inscription btn">Creer un nouveau compte</a>
        </form>
  </section>
    <section  class="inscription <?php if(isset($activeClass)) {echo $activeClass;};?>">
      <form action="index.php" method="post">
            <i id="quitter"  class="fa-solid fa-xmark"></i>
            <h1>S'inscrire</h1>
            <h4>C'est rapide</h4>
            <hr>
            <div class="input-nom-prenom">
                <div class="form-control">
                  <input type="text" id="nom" name="nom" >
                  <label class="labs" for="nom">Nom</label>
                </div>
                <div class="form-control">
                  <input type="text" id="prenom" name="prenom" >
                  <label class="labs" for="prenom">Prenom</label>
                </div>
            </div>
            
            <div class="form-control">
              <input type="email" id="email" name="email" >
              <label class="labs" for="email" >Email</label>
            </div>
            <div class="form-control">
              <input type="password" name="password" id="passwordUp" class="num-mdp" >
              <label class="labs" for="passwordUp">Mot de passe</label>
            </div>
            <div class="form-control">
              <select name="sexe" id="sexe">
                <option value="">Sexe</option>
                <option value="masculin">Masculin</option>
                <option value="feminin">Feminin</option>
              </select>
            </div>
            <div class="form-control">
            <?=showError("nom")?>
            <?=showError("prenom")?>
            <?=showError("email")?>
            <?=showError("password")?>
            <?=showError("sexe")?>
            </div>
            </div>
            <div class="texte">
                <p>En cliquant sur S’inscrire, vous acceptez nos Conditions générales, notre Politique de confidentialité et notre Politique d’utilisation des cookies. Vous recevrez peut-être des notifications par texto de notre part et vous pouvez à tout moment vous désabonner.</p>
            </div>
            <div class="center-btn-submit">
                <input type="submit" name="inscrire" class="btn" value="S'inscrire" id="inscrire">
            </div>
            <div class="form-control">
            
      </form>
    </section>
    <script src="./assets/js/animation.js" type="module" defer></script>
    <script src="./assets/js/transition.js" type="module" defer></script>
    <script src="./assets/js/function.js" type="module" defer></script>

</body>
</html>