<?php
  require_once('./dao/authentification.php');
  $page = 'enregistrement';
  $id = $_SESSION["userConnected"]["id"];
  $infos = getUserById($id);
  $posts = saveByUser($infos['id']);
  $numPost = getNumberPostById($infos['id']);
  

  
  
  if(isset($_GET['place'])) {
    echo "<script>window.location.href = '?page=enregistrement#feed{$_GET['place']}';</script>";
    exit;
  }
  if(isset($_GET['bookmark'])) {
    if(estEnregistreByUser($_GET['bookmark'], $_SESSION["userConnected"]["id"]) != 0){
      delBookmark($_GET['bookmark'], $_SESSION["userConnected"]["id"]);
    }
    echo "<script>window.location.href = '?page=enregistrement#feed{$_GET['bookmark']}';</script>";
    exit;
  }
  if(isset($_GET['signalPost'])) {
    addSignal($_GET['signalPost'], $_SESSION["userConnected"]["id"]);
    echo "<script>window.location.href = '?page=enregistrement#feed{$_GET['signalPost']}';</script>";
    exit;
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Profile page - Jokko <?=$infos['prenom']." ".$infos['nom']?></title>
    <link rel="stylesheet" href="../assets/css/enregistrement.css" />  
    <link rel="stylesheet" href="../assets/css/post.css">

    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
      integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />

  </head>
  <body>
    
    <!-- NAVBAR DEBUT -->
    <?php
      include('./pages/sousPage1/navbar.php');
    ?>
    <!-- NAVBAR FIN -->
    <!-- PROFILE PAGE -->
    <main>
      <div class="profile-container">
            <div class="profile-details">
            <div class="pd-left">
                <div class="pd-row">
                <img src="../assets/img/profile/<?=$infos['photoProfil']?>" alt="" class="pd-image" />
                <div>
                    <h3>Enregistrements</h3>
                    <p class="text-muted"><?=numberSave($_SESSION['userConnected']['id'])?> enregistrements</p>
                </div>
                </div>
            </div>
            </div>
        <div>
        </div>
        <?php

          if(isBlocked($_SESSION["userConnected"]['id'], $infos['id']) < 1) {
        ?>
        <div class="middle">
          <div class="feeds" id="feedsP">
            <?php
                foreach($posts as $post) {
                  $likes = $conn->prepare("SELECT id FROM likes WHERE post_id = ? ");
                  $likes->execute(array($post['postId']));
                  $likes = $likes->rowCount();
                  $nbrCom = $conn->prepare("SELECT id FROM commentaires WHERE post_id = ? ");
                  $nbrCom->execute(array($post['postId']));
                  $nbrCom = $nbrCom->rowCount();
                  $comments = showOneComments($post['postId']);

                
            ?>
            <div class="feed" id="<?='feed'.$post['postId']?>">
              <div class="head">
                <div class="user">
                    <div class="profile-photo">
                      <img src="../assets/img/profile/<?=$post['photoProfil']?>" alt="" />
                    </div>
                  
                  <div class="info">
                    <h3><?=$post['prenom']." ".$post['nom']?></h3>
                    <small><?=calculerDuree($post['dateCreate'])?> AGO</small>
                  </div>
                    
                </div>
                <span class="edit">
                    <?php
                        if($_SESSION["userConnected"]["id"] !== $post['user_id']){
                    ?>
                    <a href="?page=enregistrement&signalPost=<?=$post['postId']?>">
                        <i class="fa-solid fa-triangle-exclamation"></i>  
                    </a>
                    <?php
                        }
                    ?>
                    </span>
                
              </div>
              <div class="ptext">
                <p><?=$post['post_text']?></p>
              </div>
              <div class="photo">
                <a href="?page=enregistrement&idPost=<?=$post['postId']?>">
                  <img src="../assets/img/posts/<?=$post['post_img']?>" alt="" />
                </a>
              </div>
              <div class="action-buttons">
                <?php if(estAimeByUser($post['postId'], $_SESSION["userConnected"]["id"]) == 0){ ?>

                <div class="interaction-buttons">
                  <a href="?page=like&e&t=1&idPost=<?=$post['postId']?>">
                    <span><i class="fa-solid fa-thumbs-up like_btn"></i></span>
                  </a>
                </div>
                <?php }else{ ?>
                  <div class="interaction-buttons">
                  <a href="?page=like&e&t=1&idPost=<?=$post['postId']?>">
                    <span><i class="fa-solid fa-thumbs-down like_btn"></i></span>
                  </a>
                </div>
                <?php } ?>
                <div class="bookmark ">
                    <a href="?page=enregistrement&bookmark=<?=$post['postId']?>">
                        <span><i class="fa-solid fa-eraser"></i></span>
                    </a>
                </div>

              </div>
              <div class="liked-by">
                <p><b><?=$likes?></b> aimes et <b><?=$nbrCom?></b> commentaires</p>
              </div>
              <div class="caption">
              <?php
                if(!empty($comments)) {
              ?>
              <p>
                  <b><?=$comments[0]['prenom'] . " " . $comments[0]['nom']?></b> <?=$comments[0]['commentaire']?>
              </p>
              <?php
                  }else {
              ?>
              <p>
                  Aucun Commentaire
              </p>
              <?php
                  }
              ?>
              </div>
              <?php
                  if(!empty($comments)) {
              ?>
              <div class="comments text-muted"><?=calculerDuree($comments[0]['dateCommentaire'])?></div>
              <?php
                  }
              ?>
              <form action="?page=commentaire" class="create-post" method="post">
                <input type="hidden" name="id" value="<?=$post['postId']?>">
                <input type="hidden" name="e" value="">

                <div class="profile-photo">
                  <img src="../assets/img/profile/<?=$_SESSION['userConnected']['photoProfil']?>" alt="" />
                </div>
                <input type="text" placeholder="Quoi de neuf, <?=$_SESSION['userConnected']['prenom']?> ?" name="commentaire"/>

                <input type="submit" value="Publier" class="btn btn-primary" name="submit_commentaire"/>
              </form>
            </div>
            <?php
                }
            ?>
            

            <!--==========END OF FEED=============-->
          </div>
        </div>
        <?php
          }
        ?>

      </div>
      <!-- LEFT DEBUT -->
      <div class="left">
        
        <!--===========SIDEBAR===========-->
        <div class="sidebar">
          <a class="menu-item" href="index?page=accueil">
            <span><i class="fa-solid fa-house"></i></span>
          </a>
          <a href="index?page=profile" class="menu-item">
            <span><i class="fa-solid fa-user"></i></span>
          </a>
          <a href="#" class="menu-item item" id="notifications">
            <span>
              <i class="fa-regular fa-bell"
                ><small class="notification-count">9+</small></i
              >
            </span>
            <!--==========NOTIFICATIONS POPPUS=============-->
        <div class="notifications-popup">
              <div>
                <div class="profile-photo">
                  <img src="../assets/img/posts/cheikh.jpg" alt="" />
                </div>
                <div class="notification-body">
                  <b>Cheikh Sow</b> a accepté votre invitation
                  <small class="text-muted">2024-01-16</small>
                </div>
              </div>
              <div>
                <div class="profile-photo">
                  <img src="../assets/img/posts/cheikh.jpg" alt="" />
                </div>
                <div class="notification-body">
                  <b>Cheikh Sow</b> a commenté votre post
                  <small class="text-muted">2024-01-16</small>
                </div>
              </div>
              <div>
                <div class="profile-photo">
                  <img src="../assets/img/posts/cheikh.jpg" alt="" />
                </div>
                <div class="notification-body">
                  <b>Cheikh Sow</b> a aimé votre post
                  <small class="text-muted">2024-01-16</small>
                </div>
              </div>
            </div>
            <!-------------END NOTIFICATION POPUP-------->
            
          </a>
          <a href="#" class="menu-item item" id="messages-notifications">
            <span>
              <i class="fa-regular fa-envelope">
                <small class="notification-count">6</small>
              </i>
            </span>
          </a>
          <a href="#" class="menu-item active">
            <span><i class="fa-regular fa-bookmark"></i></span>
          </a>
          <a href="?page=profile&parametre" class="menu-item" id="parametres">
            <span><i class="fa-solid fa-gear"></i></span>
          </a>
          <a href="index.php?disconnect=1" class="menu-item" >
            <span><i class="fa-solid fa-arrow-right-from-bracket"></i></span>
          </a>
        </div>

        

      <!-- LEFT FIN -->
    </main>
    <div class="sectionParam">
      <?php
      if(isset($_GET['parametre'])) {
        include_once('./pages/sousPage1/parametre.php');
      }
        
      ?>
    </div>
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
    
    <script src="../assets/js/profile.js" defer></script>
    <script src="../assets/js/jquery-3.7.1.min.js"></script> 

  </body>
</html>
