
<?php
require_once('./dao/fonctions.php');
        
    if(isset($_POST['modifier'])) {
        $reponse = validateUpdateImage($_FILES['photoProfil']);
        updateDateModif($infos['id']);
        if($reponse['status']){
            $img_name = $_FILES['photoProfil']['name'];
            $img_size = $_FILES['photoProfil']['size'];
            $tmp_name = $_FILES['photoProfil']['tmp_name'];
            $img_name = $_FILES['photoProfil']['name'];
            
            $img_ex =pathinfo($img_name, PATHINFO_EXTENSION);
            $img_ex_lc =  strtolower($img_ex);
            
            $allowed_exs = array("jpg", "png", "jpeg");

            if (in_array($img_ex_lc, $allowed_exs)) {
    $new_img_name = uniqid("IMG-", true) . '.' . $img_ex_lc;

    // Premier dossier (profile)
    $img_upload_path_profile = "./assets/img/profile/" . $new_img_name;
    move_uploaded_file($tmp_name, $img_upload_path_profile);
    if(updatePhotoProfilById($new_img_name, $id)){
        addNotification($_SESSION['userConnected']['id'], "a  modifié sa photo de profil.");
    }

    // Deuxième dossier (posts)
    $img_upload_path_posts = "./assets/img/posts/" . $new_img_name;
    copy($img_upload_path_profile, $img_upload_path_posts);
    
    $phrase = $infos['prenom'] . " " . $infos['nom'] . " a changé son photo de profil";
    createPost($phrase, $new_img_name, $_SESSION["userConnected"]["id"]);
    nombre_publication();
    echo '<script type="text/javascript">window.location.href = window.location.href;</script>';
}



        }
        if(!empty($_POST['nom'])){
            updateNomById($_POST, $infos['id']);
        }
        if(!empty($_POST['prenom'])){
            updatePrenomById($_POST, $infos['id']);
        }
        if(!empty($_POST['sexe'])){
            updateSexeById($_POST, $infos['id']);
        }
        if(!empty($_POST['bio'])){
            updateBioById($_POST, $infos['id']);
        }
        if(!empty($_POST['password'])){
            updatePwdById($_POST, $infos['id']);
        }
        if(!empty($_POST['travail'])){
            updateTravailById($_POST, $infos['id']);
        }
        if(!empty($_POST['etude'])){
            updateEtudeById($_POST, $infos['id']);
        }
        if(!empty($_POST['adresse'])){
            updateAdresseById($_POST, $infos['id']);
        }
        if(!empty($_POST['dateNaissance'])){
            updateDateNaissanceById($_POST, $infos['id']);
        }
        
    }
?>
<section class="section active">
    
    <div class="form">
        <div class="top">
            <a href="../../index.php" class="back_btn"><i class="fa-solid fa-arrow-left"></i>&nbsp;Retour</a>
            <h2>Parametre</h2>
        </div>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="profileParam">
                <img src="../assets/img/profile/<?=$infos['photoProfil']?>" alt="">
                <div class="inputFile btn btn-primary">
                    <input type="file" name="photoProfil" id="uploadAvatar"  accept=".jpg,.jpeg,.png,.gif">
                </div>
                
            </div>
            <div class="formulaire">
                <div class="left">
                    <div class="input-nom-prenom">
                        <div class="form-group">
                            <input class="inputParam" type="text" id="nom" name="nom"  placeholder="nom" value="<?=$infos['nom']?>">
                            </div>
                            <div class="form-control">
                            <input class="inputParam" type="text" id="prenom" name="prenom" placeholder="prenom" value="<?=$infos['prenom']?>">
                        </div>
                    </div>
                
                    <div class="form-group">
                        <input type="date" name="dateNaissance" class="inputParam" placeholder="dateNaissance" value="<?=$infos['dateNaissance']?>">
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="inputParam" placeholder="password" >
                    </div>
                    <div class="form-group">
                        <textarea name="bio" id="" cols="30" rows="5" placeholder="Bio"><?=$infos['bio']?></textarea>
                    </div>
                    <div class="form-group">
                        <select name="sexe" id="sexe">
                            <?php
                                if($infos['sexe'] == "masculin"){
                            ?>
                            <option value="masculin">Masculin</option>
                            <option value="feminin">Feminin</option>
                            <?php
                                }else{
                            ?>
                            <option value="feminin">Feminin</option>
                            <option value="masculin">Masculin</option>
                            <?php
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="right">
            
                    <div class="form-group">
                        <input type="text" name="travail" class="inputParam" placeholder="Travail" value="<?=$infos['travail']?>">
                    </div>
                    <div class="form-group">
                        <input type="text" name="etude" class="inputParam" placeholder="Etude" value="<?=$infos['etude']?>">
                    </div>
                    <div class="form-group">
                        <input type="text" name="adresse" class="inputParam" placeholder="Adresse" value="<?=$infos['adresse']?>">
                    </div>
                    
                </div>
            </div>
            <div class="modification">
                <input class="btn btn-primary modification" type="submit" name="modifier" value="Modifier">
            </div>
        </form>
    </div>
</section>