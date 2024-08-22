<?php
global $conn;
    
    if(isset($_GET['idPost'], $_GET['t'])) {
        $getid = (int) $_GET['idPost'];
        $gett = (int) $_GET['t'];

        if($gett == 1) {
            $check_like = $conn->prepare('SELECT id FROM likes WHERE post_id = ? AND user_id = ?');
            $check_like->execute(array($getid, $_SESSION['userConnected']['id']));
            
            
            if($check_like->rowCount() == 1) {
                $del = $conn->prepare('DELETE FROM likes WHERE post_id = ? AND user_id = ?');
                $del->execute(array($getid, $_SESSION['userConnected']['id']));
            }else{
                $ins = $conn->prepare('INSERT INTO likes (post_id, user_id) VALUES (?, ?)');
                $ins->execute(array($getid, $_SESSION['userConnected']['id']));
                addNotification($_SESSION['userConnected']['id'], "a aime une publication", $getid);
            }
            
            
        }elseif($gett == 2) {

        }
        if(isset($_GET['l'])) {
            echo "<script>window.location.href = window.location.pathname + '#feed{$_GET['idPost']}';</script>";
        }elseif(isset($_GET['e'])){
            echo "<script>window.location.href = '?page=enregistrement#feed{$_GET['idPost']}';</script>";

        }else {
            echo "<script>window.location.href = '?page=accueil#feedA{$_GET['idPost']}';</script>";
        }
        exit();
        
    }
    
?>