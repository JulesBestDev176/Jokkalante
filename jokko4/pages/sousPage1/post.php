<?php
    $id =  $_GET['idPost'];
    $img = getImgById($id);
    $comments = showAllComments($id);
    
?>
<section class="section active">
    
    <div class="form">
        <div class="top">
            <a href="?page=<?=$page?>&place=<?=$id?>" class="back_btn"><i class="fa-solid fa-arrow-left"></i>&nbsp;Retour</a>
        </div>
        <div class="post">
            <div class="left">
                <img src="../../assets/img/posts/<?=$img['post_img']?>" alt="" id="imagePreview"/>
            </div>
            <div class="gauche">
                <div class="postText">
                    <!-- <div class="profile-photo">
                        <img src="../../assets/img/profile/<?=$post['photoProfil']?>" class="" alt="">
                    </div> -->
                    <p><?=$img['post_text']?></p>
                </div>
                <!-- <hr class="hr"> -->
                <div class="comments">
                    <?php
                        foreach($comments as $comment) {
                    ?>
                    <div class="comment">
                        <div class="profile-photo">
                            <img src="../../assets/img/profile/<?=$comment['photoProfil']?>" alt="" />
                        </div>
                        <div class="notification-body">
                            <b><?=$comment['prenom'] . " " . $comment['nom']?></b> <?=$comment['commentaire'] ?>
                            <small class="text-muted"></small>
                        </div>
                    </div>
                    <div class="duree text-muted">
                        <?=calculerDuree($comment['dateCommentaire']) ?>
                    </div>
                    <hr>
                    <?php
                        }
                    ?>
                    
                </div>
                <div class="">
                    <form action="" class="create-post">
                        <div class="profile-photo">
                        <img src="../../assets/img/posts/jules.jpg" alt="" />
                        </div>
                        <input type="text" placeholder="Quoi de neuf ?" />

                        <input type="submit" value="Publier" class="btn btn-primary" />
                    </form>
                </div>
                
            </div>
            
        </div>
    </div>
</section>
</body>
</html>