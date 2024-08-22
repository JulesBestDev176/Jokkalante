<?php
    $followings = getFollowing($_SESSION['userConnected']['id']);
?>
<div class="messages">
    <div class="heading">
        <h4>Messages</h4>
        <i class="fa-regular fa-pen-to-square"></i>
    </div>
    <!--========SEARCH BAR========-->
    <div class="search-bar">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input type="search" placeholder="Rechercher messages" id="message-search"/>
    </div>
    <!--========MESSAGES CATEGORY========-->
    <div class="category"></div>
    <!--========MESSAGES========-->
    <?php foreach($followings as $following) { ?>
    <div class="message">
        <div class="profile-photo">
            <img src="./assets/img/profile/<?=$following['photoProfil']?>" alt="" />
            <div class="active"></div>
        </div>
        <div class="message-body">
            <a href="?page=accueil&chat=<?=$following['id']?>">
                <h5><?=$following['prenom'] . " " . $following['nom']?></h5>
                <p class="text-bold">salut bro cv ..</p>
            </a>
        </div>
    </div>
    <?php } ?>

</div>