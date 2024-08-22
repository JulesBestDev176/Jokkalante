<?php
  if ($page === 'profile') {
      $hrefValue = '?page=profile&post';
  } else {
      $hrefValue = '?page=accueil&post';
  }
  $id = $_SESSION["userConnected"]["id"];
  
?>
<nav>
      <div class="container">
        <h2 class="logo"><span>J</span>okko</h2>
        <div class="search-bar">
          <i class="fa-solid fa-magnifying-glass"></i>
          <input type="search" name="search" id="search" placeholder="Rechercher" />
        </div>
        <div class="create">
          <a href="<?=$hrefValue?>">
            <label class="btn btn-primary" for="create-post">Publier</label>
          </a>
          <div class="profile-photo">
            <img src="../assets/img/profile/<?=$_SESSION['userConnected']['photoProfil']?>" alt="" />
          </div>
        </div>
      </div>
</nav>