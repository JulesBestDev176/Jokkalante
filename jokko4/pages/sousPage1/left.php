<?php
    $notifs = getAllNotification($_SESSION['userConnected']['id']);



?>
<div class="left">
    <a href="#" class="profile">
        <div class="profile-photo">
            <img src="../assets/img/profile/<?=$infos['photoProfil']?>" alt="" />
        </div>
        <div class="handle">
            <h4><?=$infos['prenom'] . ' ' . $infos['nom']?></h4>
            <p class="text-muted">@<?=strtolower($infos['nom'])?></p>
        </div>
    </a>
    <!--===========SIDEBAR===========-->
    <div class="sidebar">
        <a class="menu-item item active" href="#">
            <span><i class="fa-solid fa-house"></i></span>
            <h3>Accueil</h3>
        </a>
        <a href="index?page=profile" class="menu-item">
            <span><i class="fa-solid fa-user"></i></span>
            <h3>Profile</h3>
        </a>
        <a href="" class="menu-item item" id="notifications">
            <span>
                <i class="fa-regular fa-bell"><small class="notification-count"><?=numberNotifications($_SESSION['userConnected']['id'])?></small></i>
            </span>
            <h3>Notifications</h3>
            <!--==========NOTIFICATIONS POPPUS=============-->
            <div class="notifications-popup">
                <?php
                    foreach($notifs as $notif){
                        $lien = ($notif['messages'] != "a suivi")? "?page=$page&place=$notif[id_action]":"?page=profile&idFriend=$notif[id_action]";

                ?>
                
                    <div>
                    
                        <div class="profile-photo">
                            <img src="./assets/img/profile/<?=$notif['photoProfil']?>" alt="" />
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
        <a href="" class="menu-item item" id="messages-notifications">
            <span>
                <i class="fa-regular fa-envelope">
                    <small class="notification-count">0</small>
                </i>
            </span>
            <h3>Messages</h3>
        </a>
        <a href="index?page=enregistrement" class="menu-item">
            <span><i class="fa-regular fa-bookmark"></i></span>
            <h3>Enregistrements</h3>
        </a>
        <a href="?page=profile&parametre" class="menu-item">
            <span><i class="fa-solid fa-gear"></i></span>
            <h3>Parametres</h3>
        </a>
        <a href="index.php?disconnect=1" class="menu-item">
            <span><i class="fa-solid fa-arrow-right-from-bracket"></i></span>
            <h3>Déconnecter</h3>
        </a>
    </div>
    <!--========END OF SIDEBAR==========-->
    <a href="<?=$hrefValue?>"><label for="create-post" class="btn btn-primary">Faire une Publication</label></a>
</div>