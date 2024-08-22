<?php
    
    if(isset($_GET['idFollow'])) {
        followUser($_GET['idFollow']);
        addNotification($_SESSION['userConnected']['id'], "a suivi", $_GET['idFollow']);
        $id = $_GET['idUnFollow'];
        
    }
    if(isset($_GET['idUnFollow'])){
        // echo "<script>alert('hello');</script>";
        $res = unfollowUser($_GET['idUnFollow']);
        $id = $_GET['idFollow'];
    }
    
    if(isset($_GET['idBlock'])){
        $res = blocked($_SESSION['userConnected']['id'], $_GET['idBlock']);
        $id = $_GET['idUnBlock'];
    }
    if(isset($_GET['idUnBlock'])){
        $res = unBlocked($_SESSION['userConnected']['id'], $_GET['idUnBlock']);
        $id = $_GET['idBlock'];


    }
    if(isset($_GET['idDelPost'])){
        delPost($_GET['idDelPost'], $_SESSION['userConnected']['id']);
    }
    header("Location: ?page=accueil");
    exit();