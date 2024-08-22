
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
            <h1>AdminJokko</h1>
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
          <input type="submit" name="connecter" value="Se connecter" class="btn-submit btn">
        </form>
  </section>
  <script src="./assets/js/animation.js" type="module" defer></script>
  <script src="./assets/js/function.js" type="module" defer></script>
</body>
</html>