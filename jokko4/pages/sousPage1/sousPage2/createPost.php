
<?php

    if(isset($_POST)){
        $reponse = validateUpdateImage($_FILES['post_img']);

        if($reponse['status']){
            $img_name = $_FILES['post_img']['name'];
            $img_size = $_FILES['post_img']['size'];
            $tmp_name = $_FILES['post_img']['tmp_name'];
            $img_name = $_FILES['post_img']['name'];
            
            $img_ex =pathinfo($img_name, PATHINFO_EXTENSION);
            $img_ex_lc =  strtolower($img_ex);
            
            $allowed_exs = array("jpg", "png", "jpeg");

            if(in_array($img_ex_lc, $allowed_exs)){
                $new_img_name = uniqid("IMG-", true) . '.'. $img_ex_lc;
                $img_upload_path = "./assets/img/posts/".$new_img_name;
                move_uploaded_file($tmp_name, $img_upload_path);
                createPost($_POST['post_text'], $new_img_name, $_SESSION["userConnected"]["id"]);
                nombre_publication();
                echo '<script type="text/javascript">window.location.href = window.location.href;</script>';
            }


        }

    }
?>
<form action="" class="create-post" method="post">
    <div class="profile-photo">
        <img src="../../assets/img/profile/<?=$infos['photoProfil']?>" alt="" />
    </div>
    <input type="text" name="post_text" placeholder="Quoi de neuf, <?=$infos['prenom']?> ?" />
    <div class="btn btn-primary btn-img ba">
        <input
            type="file"
            name="imageUpload"
            id="imageUpload"
            name="post_img"
            accept="image/*"
            onchange="previewImage(this)"
            id="imgFile"
            title="choix"
        />
        <i class="fa-solid fa-camera"></i>
    </div>
    <input type="submit" class="btn btn-primary">
</form>