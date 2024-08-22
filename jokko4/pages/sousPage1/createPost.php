
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
<section class="section active">
    
    <div class="form">
        <div class="top">
            <a href="?page=<?=$page?>" class="back_btn"><i class="fa-solid fa-arrow-left"></i>&nbsp;Retour</a>
            <h4>Ajouter une nouvelle publication</h4>
        </div>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="img">
                <img src="" alt="" style="display:none" id="post_img">
            </div>
            <div class="inputFile btn btn-primary">
                <input type="file" name="post_img" id="select_post_img"  accept=".jpg,.jpeg,.png,.gif">
            </div>
            <div class="form-group">
                <textarea name="post_text" id="" cols="30" rows="5" placeholder="Dites quelques choses..."></textarea>  
            </div>
            <div class="publication">
                <input class="btn btn-primary" type="submit" name="publier" value="Publier">
            </div>
        </form>
    </div>
</section>

<script src="../../assets/js/custom.js?v=<?=time()?>"></script>