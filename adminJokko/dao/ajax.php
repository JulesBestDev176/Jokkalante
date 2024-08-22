<?php
    require_once 'fonctions.php';
    require_once 'connect_bd.php';
    
    if(isset($_GET['idBlock'])){
        $res = blocked($_GET['idBlock']);
        $id = $_GET['idUnBlock'];
    }
    if(isset($_GET['idUnBlock'])){
        $res = unBlocked($_GET['idUnBlock']);
        $id = $_GET['idBlock'];
    }
    // if(isset($_GET['idDelPost'])){
    //     delPost($_GET['idDelPost']);
    // }
    // if(isset($_GET['idShowPost'])){
    //     showPost($_GET['idShowPost']);
    // }
    
    header("Location: ../index.php");
    exit();