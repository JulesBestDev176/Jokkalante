<?php
// Traitement du formulaire

require_once('./dao/fonctions.php');
$direction = "../index.php?verif";
$msg = "";
$verif = false;
$style = false;
if(!empty($_POST['code']) && isset($_POST['verifier'])) {
  // Vérifier le code ici et effectuer les actions nécessaires
  $codeSaisi = $_POST['code'];
  if(verifCode($codeSaisi)) {
    
    $verif = true;
    
    $direction = "../index.php";
  } else {
    // Code incorrect, restez sur la page actuelle
    $msg = "Code incorrect";
    $style = true;
  }
  
}



 // Assurez-vous de terminer le script après la redirection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <link rel="stylesheet" href="./assets/css/fpwd.css">
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
        <form class="formulaire" method="post" action="<?=$direction?>">
          <?php
            if(!$verif) {
          ?>
            <h1>Code de vérification</h1><br>
            <p>Un code à 6 chiffres vous a  été envoyé par mail </p><br>
          <div class="form-control">
            <input type="text" name="code" id="code" placeholder="######">
            <label class="labs" for="code">Code</label>
          </div>
          <input type="submit" name="verifier" value="Verifier mail" class="btn-submit btn">
          <div class=" alert-danger" style="">
                <?=$msg?>
          </div>
          <?php
            } else {
          ?>
          <input type="submit" name="verifier" value="Confirmer" class="btn-submit btn">
          <?php
            }
          ?>
        </form>
        
    </section>
    <script src="./assets/js/animation.js" type="module" defer></script>

</body>
</html>