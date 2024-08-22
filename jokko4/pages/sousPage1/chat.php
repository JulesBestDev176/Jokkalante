<?php
    $recupMsg;
    if(isset($_GET['chat']) AND !empty($_GET['chat'])) {
        $getid = $_GET['chat'];
        $recup = recupUser($getid);
        if($recup > 0) {
            $recupMsg = recupMsg($_SESSION["userConnected"]["id"], $getid);
            if(isset($_POST['envoyer'])) {
                $message = htmlspecialchars($_POST['msg']);
                sendMessage($_SESSION["userConnected"]["id"], $getid, $message);
                header("Refresh:0");
            }
        }
        
    }
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Chatbot in JavaScript | CodingNepal</title>
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Google Fonts Link For Icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,1,0" />
    <link rel="stylesheet" href="../assets/css/chat.css">

    <script src="../assets/js/chat.js" defer></script>
  </head>
  <body>
    <button class="chatbot-toggler">
      <span class="material-symbols-rounded">mode_comment</span>
      <span class="material-symbols-outlined">close</span>
    </button>
    <div class="chatbot">
      <header>
        <h2>Messages</h2>
        <span class="close-btn material-symbols-outlined">close</span>
      </header>
      <ul class="chatbox">
        <?php 
        global $conn;
        $recupMessages = $conn->prepare("SELECT * FROM messages WHERE (idAuteur = ? AND idDestinataire = ?) OR (idAuteur = ? AND idDestinataire = ?)");
        $recupMessages->execute(array($_SESSION["userConnected"]["id"], $getid, $getid, $_SESSION["userConnected"]["id"]));
        while($msg = $recupMessages->fetch()) {
            if($msg['idAuteur'] != $_SESSION["userConnected"]["id"])  {
        ?>
        <li class="chat incoming">
          <!-- <span class="material-symbols-outlined"><img src="../assets/img/profile/<?=$msg["photoProfil"]?>" alt=""></span> -->
          <p><?=$msg["msg"]?></p>
        </li>
        <?php
            } else{
        ?>
        <li class="chat outgoing show-chatbot">
            <p><?=$msg["msg"]?></p>
        </li>
        
        <?php 
            }
        } 
        ?>
      </ul>
      
        <form class="chat-input" id="chatForm1" action="" method="post">
            <textarea name="msg" placeholder="Enter a message..." spellcheck="false" required></textarea>
            <button type="submit" name="envoyer">
                <i class="fa-solid fa-paper-plane"></i>
            </button>

            <!-- <input type="submit" name="envoyer" value=""> -->
            <!-- <span id="send-btn" class="material-symbols-rounded">send</span> -->
            <!-- </button> -->
        </form>
    </div>



        
  </body>
</html>
