<?php
    session_start();
    //requisition
    require_once 'dao/connect_bd.php';
    require_once 'dao/authentification.php';
    require_once 'dao/usersDB.php';
    require_once 'dao/fonctions.php';
    require_once 'dao/send_code.php';

    
        
    // require_once './pages/verifMail.php';
    $pageCount = count($_GET);
    //Si l'utilisateur est deja connecte 
    if(isset($_SESSION['userConnected'])){
        
        if(isset($_GET['disconnect']) && $_GET['disconnect']==1){
            unset($_SESSION['userConnected']);
            unset($_GET['emailExist']);
            header("Location: index.php");
        }elseif(isset($_GET["page"])) {
            include("pages/{$_GET["page"]}.php");
        }else{
            if(isset($_SESSION["userConnected"]) && empty($_SESSION['code'])) {
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
            nombre_connection();
            //si les infos de connections sont correctes
            if($infoUser) {
                //si l'utilisateur n'a pas ete bloque
                if($infoUser['statutAdmin'] == 1) {
                    $_SESSION["userConnected"] = $infoUser;
                    header("Location: index.php");
                    nbrConnection($infoUser);
                }else{
                    header('Location: ./pages/userBlocked.php');
                    
                        if(isset($_POST['disconnect'])) {
                            header("Location: ../index.php");
                        }
                    
                    
                    
                    
                }
            }else{
                // echo "infos incorrecte";
                $_SESSION['error'] = validateLogin($infoUser);
                header("Location: index.php");
            }
        }elseif(isset($_POST['inscrire']) && 
                isset($_POST['nom']) && 
                isset($_POST['prenom']) && 
                isset($_POST['email']) && 
                isset($_POST['password'])&& 
                isset($_POST['sexe'])
        ){
            $reponse = validadeSignupForm($_POST);
            if($reponse['status']) {
                require_once('./dao/inscription.php');
                
                if(createUser($_POST)){
                    nombre_utilisateur();
                    header('Location: index.php?verif');
                }else{
                    echo "<script>alert('Erreur');</script>";   
                }
            }else{
                $_SESSION['error'] = $reponse;
                $_SESSION['formdata'] = $_POST;
                header("Location: index.php?emailExist=$_SESSION");
            }

        }else{
            
            if(isset($_GET['verif'])) {
                require_once('./pages/verifMail.php');
                if(!$verif) {
                    include_once('./pages/verifMail.php');
                }
            }elseif(isset($_GET['forget'])){
                header('Location: ./pages/forgotPassword.php');
            }else{
                include_once('./pages/sign.php');
            }
            
        }
        
    }






?>

