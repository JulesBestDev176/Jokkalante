<?php
    $id = $_SESSION["userConnected"]["id"];
    $infos = getUserById($id);
    $suggestions = filterFollowSuggestion($id);
    
?>

<div class="messages">
    <div class="heading">
        <h4>Suggestions Amis</h4>
    </div>
    <!--========SEARCH BAR========-->
    <div class="search-bar">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input type="search" placeholder="Rechercher amis" id="message-search"/>
    </div>
    <!--========MESSAGES CATEGORY========-->
    <div class="category"></div>
    <?php
        foreach($suggestions as $suggestion) {
    ?>
    <!--========MESSAGES========-->
    <div class="amis">
        <div class="profile-photo">
            <a href="">
                <img src="./assets/img/profile/<?=$suggestion['photoProfil']?>" alt="" />
                <div class="active"></div>
            </a>
        </div>
        <div class="amis-body">
            <a href="?page=profile&idFriend=<?=$suggestion['id']?>">
                <h5><?=$suggestion['prenom'] . " " . $suggestion['nom']?></h5>
            </a>
        </div>
        <div class="">
            <a href="?page=ajax&idFollow=<?=$suggestion['id']?>">
                <input type="submit" class="btn btn-primary" value="Suivre">
            </a>
        </div>
    </div>
    <?php
        }
    ?>
    
    
</div>