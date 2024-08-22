<?php
    require_once('../dao/fonctions.php');
    $direction = "../index.php";
    $style = false;
    $msg = "";

    if(isset($_POST['valider'])){
        if(!empty($_POST['email']) && !empty($_POST['password'])){
            if(isEmailRegistered($_POST['email'])) {
                updatePassword($_POST);
                header('Location: ../index.php');
            }else{
                $msg = "Cette adresse mail n'est pas valide";
                $style = true;
            }
        }else{
            $msg = "Veuillez remplir tous les champs";
            $style = true;
        }
    }
     
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <link rel="stylesheet" href="../assets/css/fpwd.css">
    <style>
    <?php 
        if($style) {
      ?>
        .alert-danger {
          padding: 3px;
          text-align: center;
          border: 1px solid #dc3545; /* Couleur de la bordure rouge */
          border-radius: 5px;
          background-color: #f8d7da; /* Couleur de fond rouge */
          color: #721c24; /* Couleur du texte pour une meilleure lisibilité */
        }
      <?php 
        }
      ?>
    </style>
    
</head>
<body class="fpwd">
    <section class="container">
        <form class="formulaire" method="post" action="">
            <h1>Vous avez oublié votre mot de passe ?</h1>
            <br>
         <div class="form-control">
            <input type="email" name="email" id="email" >
            <label class="labs" for="email">Email</label>
          </div>
          <div class="form-control">
            <input type="password" name="password" id="password" >
            <label class="labs" for="password">Nouveau mot de pass</label>
          </div>
          <input type="submit" name="valider" value="Valider" class="btn-submit btn">
          <div class=" alert-danger" style="">
                <?=$msg?>
          </div>
        </form>
    </section>
    <script src="../assets/js/animation.js" type="module" defer></script>

</body>
</html>