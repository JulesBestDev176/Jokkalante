<?php
global $conn;
  $posts = getAllPostInAccueilById();


  

?>
<div class="feeds">
    <?php
        foreach($posts as $post) { 
            $likes = $conn->prepare("SELECT id FROM likes WHERE post_id = ? ");
            $likes->execute(array($post['postId']));
            $likes = $likes->rowCount();
            $nbrCom = $conn->prepare("SELECT id FROM commentaires WHERE post_id = ? ");
            $nbrCom->execute(array($post['postId']));
            $nbrCom = $nbrCom->rowCount();
            $comments = showOneComments($post['postId']);
            if(isBlocked($_SESSION["userConnected"]["id"], $post["user_id"]) < 1) {
    ?>
    <div class="feed" id="<?='feedA'.$post['postId']?>">
        
        <div class="head">
            <div class="user">
                <div class="profile-photo">
                    <img src="../../assets/img/profile/<?=$post['photoProfil']?>" alt="" />
                </div>
                <div class="info">
                    <a href="?page=profile&idFriend=<?=$post['user_id']?>">
                        <h3><?=$post['prenom'] . ' ' . $post['nom']?></h3>
                    </a>
                    <small><?=calculerDuree($post['dateCreate'])?> AGO</small>
                </div>
            </div>
            <span class="edit">
                <?php
                    if($_SESSION["userConnected"]["id"] === $post['user_id']){
                ?>
                <a href="?page=ajax&idDelPost=<?=$post['postId']?>">
                    <i class="fa-solid fa-trash"></i>
                </a>
                <?php
                    }else{
                ?>
                <a href="?page=accueil&signalPost=<?=$post['postId']?>">
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
            <a href="?page=accueil&idPost=<?=$post['postId']?>">
                <img src="./assets/img/posts/<?=$post['post_img']?>" alt="" />
            </a>
        </div>
        <div class="action-buttons">
            <?php if(estAimeByUser($post['postId'], $_SESSION["userConnected"]["id"]) == 0){ ?>

            <div class="interaction-buttons">
                <a href="?page=like&t=1&idPost=<?=$post['postId']?>">
                    <span><i class="fa-solid fa-thumbs-up like_btn"></i></span>
                </a>
            </div>
            <?php }else{ ?>
                <div class="interaction-buttons">
                <a href="?page=like&t=1&idPost=<?=$post['postId']?>">
                    <span><i class="fa-solid fa-thumbs-down like_btn"></i></span>
                </a>
            </div>
            <?php } ?>
            
            <?php if(estEnregistreByUser($post['postId'], $_SESSION["userConnected"]["id"]) == 0){ ?>
            <div class="bookmark ">
                <a href="?page=accueil&bookmark=<?=$post['postId']?>">
                    <span><i class="fa-regular fa-bookmark"></i></span>
                </a>
            </div>
            <?php }else{ ?>
            <div class="bookmark ">
                <a href="?page=accueil&bookmark=<?=$post['postId']?>">
                    <span><i class="fa-solid fa-eraser"></i></span>
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
        <div class="comments text-muted"> <?=calculerDuree($comments[0]['dateCommentaire'])?></div>
        <?php
            }
        ?>
        <form action="?page=commentaire" class="create-post" method="post">
                <input type="hidden" name="id" value="<?=$post['postId']?>">
                <input type="hidden" name="a" value="">
                <div class="profile-photo">
                  <img src="../assets/img/profile/<?=$infos['photoProfil']?>" alt="" />
                </div>
                <input type="text" placeholder="Quoi de neuf, <?=$infos['prenom']?> ?" name="commentaire"/>

                <input type="submit" value="Publier" class="btn btn-primary" name="submit_commentaire"/>
        </form>
    </div>
    <?php
            }
        }
    ?>
    
    <!--==========END OF FEED=============-->
</div>
