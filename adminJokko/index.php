<?php
    session_start();
    //requisition
    require_once 'dao/connect_bd.php';
    require_once 'dao/authentification.php';
    require_once 'dao/fonctions.php';
    //Si l'utilisateur est deja connecte 
    if(isset($_SESSION['userConnected'])){
        
        if(isset($_GET['disconnect']) && $_GET['disconnect']==1){
            unset($_SESSION['userConnected']);
            header("Location: index.php");
        }elseif(isset($_GET["page"])) {
            include("pages/{$_GET["page"]}.php");
        }else{
            if(isset($_SESSION["userConnected"]) ) {
                header("Location: index.php?page=profile");
            } 
             
            
        }
        
    }else{ //si l'utilisateur n'est pas encore connecte
        //si l'utilisateur valide le formulaire de connexion
        if(     isset($_POST['connecter']) && 
                isset($_POST['username']) && 
                isset($_POST['password'])
        ){
            extract($_POST);
            $infoUser = connection($username, md5($password));
            //si les infos de connections sont correctes
            if($infoUser) {
                $_SESSION["userConnected"] = $infoUser;
                header("Location: index.php");
                nbrConnection($infoUser);
            }else{
                // echo "infos incorrecte";
                $_SESSION['error'] = validateLogin($infoUser);
                header("Location: index.php");
            }
        }else{
            include_once('./pages/sign.php'); 
        }
        
    }

?>