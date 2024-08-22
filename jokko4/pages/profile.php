<?php
  require_once('./dao/authentification.php');
  $page = 'profile';
  $id = $_SESSION["userConnected"]["id"];
  $infos = getUserById($id);
  $posts = getAllPostInProfileById($infos['id']);
  $numPost = getNumberPostById($infos['id']);
  // $suggestions = filterFollowSuggestion($id);
  $verif1 = false;
  $verif2 = true;
  $numberFollowers = numberFollowers($id);
  $numberFollowing = numberFollowing($id);
  $followers = getFollowers($id);
  $followings = getFollowing($id);
  
  $notifs = getAllNotification($_SESSION['userConnected']['id']);
  
  if(isset($_GET['idFriend'])){
    $id = $_GET['idFriend'];
    $infos = getUserById($id);
    $posts = getAllPostInProfileById($infos['id']);
    $numPost = getNumberPostById($infos['id']);
    $numberFollowers = numberFollowers($id);
    $numberFollowing = numberFollowing($id);
    $followers = getFollowers($id);
    $followings = getFollowing($id);

  }elseif(isset($_GET['idFriendProfile']) ) {
    
    $id = $_GET['idFriendProfile'];
    
    $posts = getAllPostInProfileById($infos['id']);
    $numPost = getNumberPostById($infos['id']);
    $numberFollowers = numberFollowers($id);
    $numberFollowing = numberFollowing($id);
    $followers = getFollowers($id);
    $followings = getFollowing($id);
  }
  $suggestions = followings($id);
  if (isset($_GET['idFriend']) && is_array($suggestions)) {
    $idFriend = (int)$_GET['idFriend']; // Assurez-vous que $_GET['idFriend'] est un entier
    foreach ($suggestions as $suggestion) {
        if ($suggestion['id'] === $idFriend) {
          $verif1 = true;
          break; 
        }
    }
  }elseif (isset($_GET['idFriendProfile']) && is_array($suggestions)) {
    $idFriend = (int) $_GET['idFriendProfile']; // Assurez-vous que $_GET['idFriend'] est un entier
    foreach ($suggestions as $suggestion) {
        if ($suggestion['id'] === $idFriend) {
          $verif1 = true;
          break; 
        }
    }

  }
  if(isset($_GET['idDelPost'])){
    delPost($_GET['idDelPost'], $_SESSION['userConnected']['id']);
    echo "<script>window.location.href = window.location.pathname + '#feedsP';</script>";
    exit;
  }
  if(isset($_GET['place'])) {
    echo "<script>window.location.href = window.location.pathname + '#feed{$_GET['place']}';</script>";
    exit;
  }

  $infos = getUserById($id);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Profile page - Jokko <?=$infos['prenom']." ".$infos['nom']?></title>
    <link rel="stylesheet" href="../assets/css/profile.css" />
    <link rel="stylesheet" href="../assets/css/parametre.css" />  
    <link rel="stylesheet" href="../assets/css/createPost.css" /> 
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
    // var_dump($infos);
      include('./pages/sousPage1/navbar.php');
    ?>
    <!-- NAVBAR FIN -->
    <!-- PROFILE PAGE -->
    <main>
      <div class="profile-container">
        
        <img src="../assets/img/profile/<?=$infos['photoProfil']?>" alt="" class="cover-img" />
        <div class="profile-details">
          <div class="pd-left">
            <div class="pd-row">
              <img src="../assets/img/profile/<?=$infos['photoProfil']?>" alt="" class="pd-image" />
              <div>
                <h3><?=$infos['prenom']." ".$infos['nom']?></h3>
                <div>
                  <div class="btn btn-primary">
                    <i class="fa-solid fa-user-group"></i> &nbsp;<?=$numberFollowers?> Followers
                  </div>
                  <div class="btn btn-primary">
                    <i class="fa-solid fa-user"></i> &nbsp;<?=$numberFollowing?> Following
                  </div>
                  
                </div>
                
              </div>
            </div>
          </div>
          
          <div class="pd-right">
            <?php 
              if(
                (isset($_GET['idFriend']) AND 
                  ($_GET['idFriend'] != $_SESSION["userConnected"]["id"]) or 
                (isset($_GET['idFriendProfile']) AND 
                  ($_GET['idFriendProfile']) != $_SESSION["userConnected"]["id"]))) {
                    if(
                      (
                        (isset($_GET['idFriend']) AND verifBlock($_SESSION['userConnected']['id'], $_GET['idFriend']) >=1)
                      ) OR
                      (
                        (isset($_GET['idFriendProfile']) AND verifBlock($_SESSION['userConnected']['id'], $_GET['idFriendProfile']) >=1)
                      )
                    ){
                      $verif2 = false;
                    }
                if ($verif1) {
            ?>
            <a href="?page=ajax&idFollow=<?=$infos['id']?>">
              <input type="submit" class="btn btn-primary" value="Suivre">
            </a>
            <?php
              }else{
            ?>
            <a href="?page=ajax&idUnFollow=<?=$infos['id']?>">
              <input type="submit" class="btn btn-red" value="Retirer">
            </a>
            <?php
              }
              if ($verif2) {
            ?>
            <a href="?page=ajax&idBlock=<?=$infos['id']?>">
              <input type="submit" class="btn btn-red" value="Bloquer">
            </a>
            <?php
              }else{
            ?>
            <a href="?page=ajax&idUnBlock=<?=$infos['id']?>">
              <input type="submit" class="btn btn-primary" value="Debloquer">
            </a>
            <?php
              }
              
            ?>
            <a href="?page=accueil&chat=<?=$infos['id']?>" class="btn btn-primary" >
              <i class="fa-brands fa-facebook-messenger"></i> Envoyer un message
            </a>
            <?php
              }
            ?>
          </div>
        </div>
        <div>
          <!-- <form action="" class="create-post">
            <div class="profile-photo">
              <img src="../assets/img/profile/" alt="" />
            </div>
            <input type="text" placeholder="Quoi de neuf,  ?" />
            <div class="btn btn-primary btn-img">
              <input
                type="file"
                name="imageUpload"
                id="imageUpload"
                accept="image/*"
                onchange="previewImage(this)"
                id="imgFile"
              />
              <i class="fa-solid fa-camera"></i>
            </div>
            <input type="submit" value="Publier" class="btn btn-primary" />
          </form> -->
        </div>
        <?php

          if(isBlocked($_SESSION["userConnected"]['id'], $infos['id']) < 1) {
        ?>
        <div class="middle">
          <div class="info-col">
            <div class="profile-intro">
              <h3>Intro</h3>
              <p class="intro-text"><?=($infos['bio'])?$infos['bio']:"Aucune"?></p>
              <hr />
              <ul>
                <li><i class="fa-solid fa-briefcase"></i> a travaillé à <?=($infos['travail'])?$infos['travail']:"...";?></li>
                <li><i class="fa-solid fa-briefcase"></i> a étudié à <?=($infos['etude'])?$infos['etude']:"...";?></li>
                <li><i class="fa-solid fa-location-dot"></i> habite à <?=($infos['adresse'])?$infos['adresse']:"...";?></li>
              </ul>
            </div>
            <div class="profile-intro">
              <div class="title-box">
                <h3>Publication</h3>
                <a href="#"><?=$numPost?> Publications</a>
              </div>
              <div class="photo-box">
              <?php
                foreach($posts as $post) {      
              ?>
              <div>
                <a href="?page=profile&idPost=<?=$post['id']?>">
                  <img src="../assets/img/posts/<?=$post['post_img']?>" />
                </a>
              </div>
              <?php
                }
              ?>
              </div>
            </div>
            <div class="profile-intro">
              <div class="title-box">
                <h3>Followings</h3>
                <a href="#"><?=$numberFollowing?> Followings</a>
              </div>
              <div class="friends-box">
                <?php
                  foreach($followings as $following){
                ?>
                  <div>
                    <a href="?page=profile&idFriendProfile=<?=$following['id']?>">
                      <img src="../assets/img/profile/<?=$following['photoProfil']?>" />
                      <p><?=$following['prenom']." ".$following['nom']?></p>
                    </a>
                  </div>
                <?php
                  }
                ?>
                
              </div>
            </div>
            <div class="profile-intro">
              <div class="title-box">
                <h3>Followers</h3>
                <a href="#"><?=$numberFollowers?> Followers</a>
              </div>
              <div class="friends-box">
                <?php
                  foreach($followers as $follower){
                    
                ?>
                  <div>
                    <a href="?page=profile&idFriendProfile=<?=$follower['id']?>">
                      <img src="../assets/img/profile/<?=$follower['photoProfil']?>" />
                      <p><?=$follower['prenom']." ".$follower['nom']?></p>
                    </a>
                  </div>
                <?php
                  }
                ?>
                
              </div>
            </div>
          </div>
          <div class="feeds" id="feedsP">
            <?php
                foreach($posts as $post) {
                  $likes = $conn->prepare("SELECT id FROM likes WHERE post_id = ? ");
                  $likes->execute(array($post['id']));
                  $likes = $likes->rowCount();
                  $nbrCom = $conn->prepare("SELECT id FROM commentaires WHERE post_id = ? ");
                  $nbrCom->execute(array($post['id']));
                  $nbrCom = $nbrCom->rowCount();
                  $comments = showOneComments($post['id']);

                
            ?>
            <div class="feed" id="<?='feed'.$post['id']?>">
              <div class="head">
                <div class="user">
                    <div class="profile-photo">
                      <img src="../assets/img/profile/<?=$infos['photoProfil']?>" alt="" />
                    </div>
                  
                  <div class="info">
                    <h3><?=$infos['prenom']." ".$infos['nom']?></h3>
                    <small><?=calculerDuree($post['dateCreate'])?> AGO</small>
                  </div>
                </div>
                <span class="edit">
                    <?php
                        if($_SESSION["userConnected"]["id"] === $post['user_id']){
                    ?>
                    <a href="?page=ajax&idDelPost=<?=$post['id']?>">
                        <i class="fa-solid fa-trash"></i>
                    </a>
                    <?php
                        }else{
                    ?>
                    <a href="?page=profile&signalPost=<?=$post['id']?>">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </a>
                    <?php
                        }
                    ?>

                  <!-- <a href="?page=profile&idDelPost=<?=$post['id']?>">
                    <i class="fa-solid fa-trash"></i>
                  </a> -->
                </span>
              </div>
              <div class="ptext">
                <p><?=$post['post_text']?></p>
              </div>
              <div class="photo">
                <a href="?page=profile&idPost=<?=$post['id']?>">
                  <img src="../assets/img/posts/<?=$post['post_img']?>" alt="" />
                </a>
              </div>
              <div class="action-buttons">
                <?php if(estAimeByUser($post['id'], $_SESSION["userConnected"]["id"]) == 0){ ?>

                <div class="interaction-buttons">
                  <a href="?page=like&l&t=1&idPost=<?=$post['id']?>">
                    <span><i class="fa-solid fa-thumbs-up like_btn"></i></span>
                  </a>
                </div>
                <?php }else{ ?>
                  <div class="interaction-buttons">
                  <a href="?page=like&l&t=1&idPost=<?=$post['id']?>">
                    <span><i class="fa-solid fa-thumbs-down like_btn"></i></span>
                  </a>
                </div>
                <?php } ?>

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
                <input type="hidden" name="id" value="<?=$post['id']?>">
                <input type="hidden" name="b" value="">

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
          <a href="#" class="menu-item item active">
            <span><i class="fa-solid fa-user"></i></span>
          </a>
          <a href="#" class="menu-item item" id="notifications">
            <span>
              <i class="fa-regular fa-bell"
                ><small class="notification-count"><?=numberNotifications($_SESSION['userConnected']['id'])?></small></i
              >
            </span>
            <!--==========NOTIFICATIONS POPPUS=============-->
        <div class="notifications-popup">
              <?php
                    foreach($notifs as $notif){
                        $lien = ($notif['messages'] != "a suivi")? "?page=$page&place=$notif[id_action]":"?page=profile&idFriend=$notif[id_action]";
                ?>
              <div>
                  <div class="profile-photo">
                    <img src="../assets/img/profile/<?=$notif['photoProfil']?>" alt="" />
                  </div>
                  <a href="<?=$lien?>">
                    <div class="notification-body">
                      <b><?=$notif['prenom'] . " " . $notif['nom']?></b> <?=$notif['messages']?>
                      <small class="text-muted"><?=calculerDuree($notif['dateNotification'])?></small>
                    </div>
                  </a>
                </div>
              <?php
                    }
              ?>
            
            </div>
            <!-------------END NOTIFICATION POPUP-------->
            
          </a>
          <a href="?page=accueil" class="menu-item" id="messages-notifications">
            <span>
              <i class="fa-regular fa-envelope">
                <small class="notification-count">6</small>
              </i>
            </span>
          </a>
          <a href="index.php?page=enregistrement" class="menu-item">
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
