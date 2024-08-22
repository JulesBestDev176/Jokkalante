<?php
    global $conn;
    if(isset($_POST['submit_commentaire'])) {
        if(isset($_POST['commentaire']) and !empty($_POST['commentaire'])) {
            $commentaire = htmlspecialchars($_POST['commentaire']);
            $id = (int)$_POST['id'];
            $ins = $conn->prepare('INSERT INTO commentaires (commentaire, post_id, user_id) VALUES (?, ?, ?)');
            $ins->execute(array($commentaire, $id, $_SESSION['userConnected']['id']));
            addNotification($_SESSION['userConnected']['id'], "a commente une publication", $id);
        }
    }
    if(isset($_POST['a'])) {
      echo "<script>window.location.href = '?page=accueil#feedA{$_POST['id']}';</script>";
    }elseif(isset($_POST['e'])){
      echo "<script>window.location.href = '?page=enregistrement#feed{$_POST['id']}';</script>";
    }else {
      echo "<script>window.location.href = window.location.pathname + '#feed{$_POST['id']}';</script>";
    }
?>