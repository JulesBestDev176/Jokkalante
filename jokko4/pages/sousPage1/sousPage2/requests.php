<?php
  $suggestions = verifFollow($_SESSION["userConnected"]["id"]);
    // var_dump($suggestions);

?>
<div class="friend-requests">
        <?php
            foreach ($suggestions as $suggestion) {
                
        ?>
    <h4>Demandes</h4>
    
        <div class="request">
            <div class="info">
                <div class="profile-photo">
                    <img src="./assets/img/profile/<?=$suggestion['photoProfil']?>" alt="" />
                </div>
                <div>
                    <br>
                    <h5><?=$suggestion['prenom'] . " " . $suggestion['nom']?></h5>
                    <!-- <p class="text-muted">8 amis en commun</p> -->
                </div>
                <a href="" class="btn btn-primary">Suivre</a>
            </div>
        </div>
    <?php
            
        }
    ?>
    
    
</div>