<?php
require_once 'connect_bd.php';

// Fonction pour afficher erreurs
function showError($field) {
    if(isset($_SESSION['error'])){
        $error = $_SESSION['error'];
        if(isset($error['field']) && $field == $error['field']){
            ?>
            <style>
                .alert-danger {
                    padding: 3px;
                    border: 1px solid #dc3545; /* Couleur de la bordure rouge */
                    border-radius: 5px;
                    background-color: #f8d7da; /* Couleur de fond rouge */
                    color: #721c24; /* Couleur du texte pour une meilleure lisibilité */
                }
            </style>
            <div class="alert-danger" style="">
                <?=$error['msg']?>
            </div>
            <?php
        }
    }
}
function validateLogin($valid) {
    $reponse = array();
    if(!$valid){
        $reponse['msg'] = "Le nom d'utilisateur ou mot de passe est incorrecte";
        $reponse['status'] = false;
        $reponse['field'] = 'log';
    }
    return $reponse;
    
}
function getNumberUser() {
    global $conn;
    // Requête SQL pour compter le nombre d'utilisateurs
    $sql = "SELECT COUNT(*) AS total FROM users WHERE typeUser = 'simple'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['total'];
}
function getNumberPost() {
    global $conn;
    // Requête SQL pour compter le nombre d'utilisateurs
    $sql = "SELECT COUNT(*) AS total FROM posts";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['total'];
}
function getNumberConnection() {
    global $conn;
    // Requête SQL pour compter le nombre d'utilisateurs
    $sql = "SELECT SUM(nombreConnection) AS total FROM users WHERE typeUser = 'simple'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['total'];
}

function getUsersFromTable() {
    global $conn;
    $users = array();
    $sql = "SELECT user FROM nombre_utilisateur";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
        $users[] = $row[0]; 
    }
    return $users; 
}
function getPostFromTable() {
    global $conn;
    $posts = array();
    $sql = "SELECT pub FROM nombre_publication";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
        $posts[] = $row[0]; 
    }
    return $posts; 
}
function getConnFromTable() {
    global $conn;
    $con = array();
    $sql = "SELECT connection FROM nombre_connection";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
        $con[] = $row[0]; 
    }
    return $con; 
}

function tailleTableauPlusLong($tab1, $tab2, $tab3) {
    $taille1 = count($tab1);
    $taille2 = count($tab2);
    $taille3 = count($tab3);

    // Comparaison des tailles
    if ($taille1 >= $taille2 && $taille1 >= $taille3) {
        return $taille1;
    } elseif ($taille2 >= $taille1 && $taille2 >= $taille3) {
        return $taille2;
    } else {
        return $taille3;
    }
}

function getAllUser($id){
    global $conn;
    $sql = $conn->prepare("SELECT * FROM users WHERE id != :id");
    $sql->bindParam(':id', $id, PDO::PARAM_INT);
    $sql->execute();
    $results = $sql->fetchAll(PDO::FETCH_ASSOC);
    return $results;
    
}
function getNumberConnById($id){
    global $conn;
    $sql = $conn->prepare("SELECT nombreConnection FROM users WHERE id = :id");
    $sql->bindParam(':id', $id, PDO::PARAM_INT);
    $sql->execute();
    $result = $sql->fetch(PDO::FETCH_ASSOC);
    if ($result) {
        return $result['nombreConnection'];
    } else {
        return false; // Retourner false si l'utilisateur avec l'id donné n'est pas trouvé
    }
}


function getNumberPostById($id) {
    global $conn;

    $sql = "SELECT count(*) as lm FROM posts WHERE user_id = :id AND statutAdmin = 1 AND statutUser = 1 ";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    $result = $stmt->fetchColumn();
    
    return $result;
}

function getAllPostInAccueil() {
    global $conn;
    $sql = $conn->prepare("SELECT posts.id as postId, users.nom as nom, users.prenom as prenom, users.photoProfil as photoProfil, users.id as user_id, users.typeUser as typeUser, 
                                  posts.post_img as post_img, posts.post_text as post_text,  posts.dateCreate as dateCreate, posts.statutAdmin as statutAdmin
                          FROM posts
                          INNER JOIN users ON posts.user_id = users.id
                          WHERE posts.statutUser = 1
                          ORDER BY posts.dateCreate DESC");

    $sql->execute();
    $results = $sql->fetchAll(PDO::FETCH_ASSOC);
    return $results;
}

function calculerDuree($timestamp) {
    $maintenant = time();
     // Timestamp actuel
    $difference = $maintenant - strtotime($timestamp);

    if ($difference < 60) {
        return $difference . ' secondes';
    } elseif ($difference < 3600) {
        return round($difference / 60) . ' minutes';
    } elseif ($difference < 86400) {
        return round($difference / 3600) . ' heures';
    } elseif ($difference < 2592000) {
        return round($difference / 86400) . ' jours';
    } elseif ($difference < 31536000) {
        return round($difference / 2592000) . ' mois';
    } else {
        return round($difference / 31536000) . ' années';
    }
}

function showAllComments($postId) {
    global $conn;

    $sql = "SELECT * FROM users as u, commentaires as c WHERE u.id = c.user_id AND c.post_id = :postId ORDER BY dateCommentaire DESC;";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':postId', $postId);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function delPost($idPost){
    global $conn;
    $sql = "UPDATE posts SET statutAdmin = 0 WHERE posts.id = :idP";
    $sql = $conn->prepare($sql);
    $sql->bindParam(':idP', $idPost);
    $sql->execute();
}
function showPost($idPost){
    global $conn;
    $sql = "UPDATE posts SET statutAdmin = 1 WHERE posts.id = :idP";
    $sql = $conn->prepare($sql);
    $sql->bindParam(':idP', $idPost);
    $sql->execute();
}
function blocked($idUser){
    global $conn;
    $sql = "UPDATE users SET statutAdmin = 0 WHERE users.id = :idU";
    $sql = $conn->prepare($sql);
    $sql->bindParam(':idU', $idUser);
    $sql->execute();
}
function unBlocked($idUser){
    global $conn;
    $sql = "UPDATE users SET statutAdmin = 1 WHERE users.id = :idU";
    $sql = $conn->prepare($sql);
    $sql->bindParam(':idU', $idUser);
    $sql->execute();
}

function getAllSignal() {
    global $conn;

    $sql = "SELECT u.nom as nom, u.prenom as prenom, s.msg as msg, s.dateSignale as dateSignale, p.id as idPost  FROM users u, signales s, posts p WHERE u.id = s.idUser AND s.idPost = p.id  ORDER BY dateSignale DESC;";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getPostById($id){
    global $conn;

    $sql = "SELECT posts.id as postId, users.nom as nom, users.prenom as prenom, users.photoProfil as photoProfil, users.id as user_id, users.typeUser as typeUser, 
                                  posts.post_img as post_img, posts.post_text as post_text,  posts.dateCreate as dateCreate, posts.statutAdmin as statutAdmin
                          FROM posts
                          INNER JOIN users ON posts.user_id = users.id
                          WHERE posts.statutUser = 1 AND posts.id = :id
                          ORDER BY posts.dateCreate DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}


?>