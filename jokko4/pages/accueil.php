<?php
  require_once('./dao/authentification.php');
  
  $page = 'accueil';
  $id = $_SESSION["userConnected"]["id"];
  $infos = getUserById($id);
  if(isset($_GET['bookmark'])) {
    if(estEnregistreByUser($_GET['bookmark'], $_SESSION["userConnected"]["id"]) == 0){
      newBookmark($_GET['bookmark'], $_SESSION["userConnected"]["id"]);
      
    }else{
      delBookmark($_GET['bookmark'], $_SESSION["userConnected"]["id"]);
      
    }
    echo "<script>window.location.href = '?page=accueil#feedA{$_GET['bookmark']}';</script>";
    exit;
  }
  if(isset($_GET['signalPost'])) {
    addSignal($_GET['signalPost'], $_SESSION["userConnected"]["id"]);
    echo "<script>window.location.href = '?page=accueil#feedA{$_GET['signalPost']}';</script>";
    exit;
  }

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Accueil page - Jokko</title>
    <link rel="stylesheet" href="assets/css/accueil.css" />
    <link rel="stylesheet" href="../assets/css/createPost.css" />  
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
      integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <link rel="stylesheet" href="../assets/css/post.css">
    

  </head>
  <body>
    <!--=============NAVBAR DEBUT=========-->
    
    <?php
      include('./pages/sousPage1/navbar.php');
    ?>

    <!--=============NAVBAR FIN=========-->


    <!--=============MAIN===============-->
    <main>
      <div class="container">
        <!--==========LEFT=============-->
        <?php
          include('./pages/sousPage1/left.php');
        ?>
        <!--========END OF LEFT==========-->

        <!--==========MIDDLE=============-->
        <?php
          include('./pages/sousPage1/middle.php');
        ?>
        <!--==========END OF MIDDLE=============-->

        <!--==========RIGHT DEBUT=============-->
        <?php
          include('./pages/sousPage1/right.php');
        ?>
        <!--==========RIGHT END===============-->
      </div>
    </main>
    <div class="sectionPost">
      <?php
      if(isset($_GET['post'])) {
        include_once('./pages/sousPage1/createPost.php');
      }
        
      ?>
    </div>
    <div class="sectionCardPost">
    <?php
      if(isset($_GET['idPost'])) {
        include_once('./pages/sousPage1/post.php');
      }
        
      ?>
    </div>
    <div class="sectionChat">
    <?php
      if(isset($_GET['chat'])) {
        include_once('./pages/sousPage1/chat.php');
      }
        
      ?>
    </div>
    <script src="../assets/js/accueil.js" defer></script>
    <script src="../assets/js/jquery-3.7.1.min.js"></script>


  </body>
</html>
