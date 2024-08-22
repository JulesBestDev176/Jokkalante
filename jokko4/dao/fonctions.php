<?php
require_once 'connect_bd.php';

//fonction pour suivre un utilisateur
function followUser($user_id) {
    global $conn;
    $current_user = $_SESSION['userConnected']['id'];
    $sql = "INSERT INTO amis(user_id1, user_id2) VALUES(:c, :u)";
    $exe = $conn->prepare($sql);

    $exe->bindParam(':c', $current_user);
    $exe->bindParam(':u', $user_id);

    $exe->execute();
        
}
function unfollowUser($user_id) {
    global $conn;
    $current_user = $_SESSION['userConnected']['id'];
    $sql = "DELETE FROM amis WHERE (user_id1 = :c AND user_id2 = :u)";
    $exe = $conn->prepare($sql);

    $exe->bindParam(':c', $current_user);
    $exe->bindParam(':u', $user_id);

    return $exe->execute();
}

function numberFollowing($id){
    global  $conn;
    $sql = "SELECT COUNT(*) FROM amis WHERE user_id1 = :id1";
    $exe=$conn->prepare($sql);
    $exe->bindParam(':id1', $id);
    $exe->execute();

    $result = $exe->fetchColumn();
    
    return $result;
}
function numberFollowers($id){
    global  $conn;
    $sql = "SELECT COUNT(*) FROM amis WHERE user_id2 = :id2";
    $exe=$conn->prepare($sql);
    $exe->bindParam(':id2', $id);
    $exe->execute();

    $result = $exe->fetchColumn();
    
    return $result;
}

function followings($id){
    global  $conn;
    $sql = "SELECT * FROM users u, amis a WHERE u.id = a.user_id1 AND a.user_id1 = :id2";
    $exe=$conn->prepare($sql);
    $exe->bindParam(':id2', $id);
    $exe->execute();

    $result = $exe->fetchAll(PDO::FETCH_ASSOC);
    
    return $result;
}

function getFollowers($id) {
    global $conn;
    $sql = $conn->prepare("SELECT * FROM users as u, amis as a WHERE u.id = a.user_id1 AND a.user_id2 = :id1");
    $sql->bindParam(':id1', $id);
    $sql->execute();
    $result = $sql->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}
function getFollowing($id) {
    global $conn;
    $sql = $conn->prepare("SELECT * FROM users as u, amis as a WHERE u.id = a.user_id2 AND a.user_id1 = :id2");
    $sql->bindParam(':id2', $id);
    $sql->execute();
    $result = $sql->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

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
function recupNbreConnection($id){
    global $conn;
    $sql = $conn->prepare("SELECT nombreConnection FROM users WHERE id = :id");
    $sql->bindParam(':id', $id);
    $sql->execute();
    $result = $sql->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function nbrConnection($form_data){
    global $conn;
    $id = $form_data['id'];
    $nbr = recupNbreConnection($id);
    $val = $nbr['nombreConnection'] + 1;
    $sql = $conn->prepare("UPDATE users SET nombreConnection = :val WHERE id = :id;");
    $sql->bindParam(':id', $id);
    $sql->bindParam(':val', $val);
    $sql->execute();
    

}
//pour modifier un password

function updatePassword($form_data) {
    global $conn;
    $password = md5($form_data['password']);
    $sql = $conn->prepare("UPDATE users SET password = :p WHERE email = :e;");
    $sql->bindParam(':p', $password);
    $sql->bindParam(':e', $form_data['email']);
    $sql->execute();
}
// pour verifier unicite email
function isEmailRegistered($email) {
    global $conn;

    $sql = "SELECT count(*) as lm FROM users WHERE email = :email";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    $result = $stmt->fetchColumn();
    
    return $result;
}

//fonction pour verifier code

function verifCode($code){
    global $conn;
    $sql = "SELECT codeValidation  FROM users WHERE codeValidation = :c";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':c', $code);
    $stmt->execute();

    return $result = $stmt->fetchColumn();
    
}

//Pour valider la connexion
function validateLogin($valid) {
    $reponse = array();
    if(!$valid){
        $reponse['msg'] = "Le nom d'utilisateur ou mot de passe est incorrecte";
        $reponse['status'] = false;
        $reponse['field'] = 'log';
    }
    return $reponse;
    
}
//Pour valider l'inscription
function validadeSignupForm($form_data){
    $reponse = array();
    $reponse['status'] = true;
    
    if(!$form_data['sexe']){
        $reponse['msg'] = "Le sexe n'est pas defini";
        $reponse['status'] = false;
        $reponse['field'] = 'sexe';
    }
    if(!$form_data['password']){
        $reponse['msg'] = "Le mot de passe n'est pas defini";
        $reponse['status'] = false;
        $reponse['field'] = 'password';
    }
    if(!$form_data['email']){
        $reponse['msg'] = "L'email n'est pas defini";
        $reponse['status'] = false;
        $reponse['field'] = 'email';
    }
    if(!$form_data['prenom']){
        $reponse['msg'] = "Le nom n'est pas defini";
        $reponse['status'] = false;
        $reponse['field'] = 'nom';
    }
    if(!$form_data['nom']){
        $reponse['msg'] = "Le nom n'est pas defini";
        $reponse['status'] = false;
        $reponse['field'] = 'nom';
    }
    if(isEmailRegistered($form_data['email'])){
        $reponse['msg'] = "L'email est déjà utilisé";
        $reponse['status'] = false;
        $reponse['field'] = 'email';
    }

    
    
    return $reponse;
}

//fonction pour valider une image
function validateUpdateImage($image_data){
    $reponse = array();
    $reponse['status'] = true;

    if($image_data['name']) {
        $image = basename($image_data['name']);
        $type = strtolower(pathinfo($image, PATHINFO_EXTENSION));
        $size = $image_data['size']/1000;

        if($type != 'jpg' && $type != 'jpeg' && $type != 'png'){
            echo "<script>alert('Seulement les images avec extensions jpg, jpeg, png');</script>";
             $reponse['status'] = false;

        }
        if($size>1000){
            echo "<script>alert('La taille est trop grande');</script>";
            $reponse['status'] = false;

        }
        return $reponse;
    }

}

// function pour mettre a jour un user
function updateNomById($form_data, $id) {
    global $conn;
    $nom = htmlspecialchars($form_data['nom'], ENT_QUOTES, 'UTF-8');

    $sql = $conn->prepare("UPDATE users SET nom = :n WHERE id = :i;");
    $sql->bindParam(':i', $id);
    $sql->bindParam(':n', $nom);
    $sql->execute();
}
function updatePrenomById($form_data, $id) {
    global $conn;
    $prenom = htmlspecialchars($form_data['prenom'], ENT_QUOTES, 'UTF-8');

    $sql = $conn->prepare("UPDATE users SET prenom = :p WHERE id = :i;");
    $sql->bindParam(':i', $id);
    $sql->bindParam(':p', $prenom);
    $sql->execute();
}
function updateSexeById($form_data, $id) {
    global $conn;
    $sql = $conn->prepare("UPDATE users SET sexe = :s WHERE id = :i;");
    $sql->bindParam(':i', $id);
    $sql->bindParam(':s', $form_data['sexe']);
    $sql->execute();
}

function updateBioById($form_data, $id) {
    global $conn;
    $bio = htmlspecialchars($form_data['bio'], ENT_QUOTES, 'UTF-8');
    $sql = $conn->prepare("UPDATE users SET bio = :b WHERE id = :i;");
    $sql->bindParam(':i', $id);
    $sql->bindParam(':b', $bio);
    $sql->execute();
}
function updatePwdById($form_data, $id) {
    global $conn;
    $password = md5($form_data['password']);
    $sql = $conn->prepare("UPDATE users SET password = :p WHERE id = :i;");
    $sql->bindParam(':i', $id);
    $sql->bindParam(':p', $password);
    $sql->execute();
}
function updateTravailById($form_data, $id) {
    global $conn;
    $travail = htmlspecialchars($form_data['travail'], ENT_QUOTES, 'UTF-8');

    $sql = $conn->prepare("UPDATE users SET travail = :t WHERE id = :i;");
    $sql->bindParam(':i', $id);
    $sql->bindParam(':t', $travail);
    $sql->execute();
}
function updateEtudeById($form_data, $id) {
    global $conn;
    $etude = htmlspecialchars($form_data['etude'], ENT_QUOTES, 'UTF-8');

    $sql = $conn->prepare("UPDATE users SET etude = :e WHERE id = :i;");
    $sql->bindParam(':i', $id);
    $sql->bindParam(':e', $etude);
    $sql->execute();
}
function updateAdresseById($form_data, $id) {
    global $conn;
    $adresse = htmlspecialchars($form_data['adresse'], ENT_QUOTES, 'UTF-8');
    $sql = $conn->prepare("UPDATE users SET adresse = :a WHERE id = :i;");
    $sql->bindParam(':i', $id);
    $sql->bindParam(':a', $adresse);
    $sql->execute();
}
function updateDateNaissanceById($form_data, $id) {
    global $conn;

    // Convertir la date au format "AAAA-MM-JJ"
    $formattedDate = date('Y-m-d', strtotime($form_data['dateNaissance']));

    $sql = $conn->prepare("UPDATE users SET dateNaissance = :dn WHERE id = :i;");
    $sql->bindParam(':i', $id);
    $sql->bindParam(':dn', $formattedDate);
    $sql->execute();
}

function updateDateModif($id) {
    global $conn;

    $sql = $conn->prepare("UPDATE users SET dateModification = CURRENT_TIMESTAMP WHERE id = :i;");
    $sql->bindParam(':i', $id);
    $sql->execute();
}
function updatePhotoProfilById($name, $id) {
    global $conn;
    $sql = $conn->prepare("UPDATE users SET photoProfil = :p WHERE id = :i;");
    $sql->bindParam(':i', $id);
    $sql->bindParam(':p', $name);
    $sql->execute();
}

function createPost($text, $name, $id) {
    global $conn;

    $text1 = htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
    $sql = "INSERT INTO posts(user_id, post_img, post_text) VALUES (:u_id, :p_img, :p_text)";
    $exe = $conn->prepare($sql);

    $exe->bindParam(':u_id', $id);
    $exe->bindParam(':p_img', $name);
    $exe->bindParam(':p_text', $text1);

    // Exécution de l'insertion
    try {
        $result = $exe->execute();
        if ($result) {
            $postId = $conn->lastInsertId(); // Obtenez l'ID du post inséré
            // createLike($id,$postId); // Appelez createLike() avec l'ID du post inséré comme paramètre
            addNotification($id, "a fait une publication", $postId);
        }
        
        return $result;
    } catch (PDOException $e) {
        echo "Erreur d'insertion : " . $e->getMessage();
        return false;
    }
}

//pour afficher tous les posts dans le profile
function getAllPostInProfileById($id) {
    global $conn;
    $sql = $conn->prepare("SELECT * FROM posts WHERE user_id = :id AND statutAdmin = 1 AND statutUser = 1 ORDER BY dateCreate DESC");
    $sql->bindParam(':id', $id);
    $sql->execute();
    $results = $sql->fetchAll(PDO::FETCH_ASSOC);
    return $results;
}

function getAllPostInAccueilById() {
    global $conn;
    $sql = $conn->prepare("SELECT posts.id as postId, users.nom as nom, users.prenom as prenom, users.photoProfil as photoProfil, users.id as user_id,
                                  posts.post_img as post_img, posts.post_text as post_text,  posts.dateCreate as dateCreate
                          FROM posts
                          INNER JOIN users ON posts.user_id = users.id
                          WHERE posts.statutAdmin = 1 AND posts.statutUser = 1 
                          ORDER BY posts.dateCreate DESC");

    $sql->execute();
    $results = $sql->fetchAll(PDO::FETCH_ASSOC);
    return $results;
}

// Fonction de calcul de durée
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

function getImgById($id) {
    global $conn;
    $sql = "SELECT * FROM posts WHERE id = :i";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':i', $id);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}
//recuperer le nombre de publications d'un utilisateur
function getNumberPostById($id) {
    global $conn;

    $sql = "SELECT count(*) as lm FROM posts WHERE user_id = :id AND statutAdmin = 1 AND statutUser = 1 ";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    $result = $stmt->fetchColumn();
    
    return $result;
}

//recuperer le nombre de publications total
function getAllNumberPost() {
    global $conn;

    $sql = "SELECT count(*) as lm FROM posts";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $result = $stmt->fetchColumn();
    
    return $result;
}

//Pour avoir des suggestions d'amis
function getFollowSuggestions() {
    global $conn;
    $current_user = $_SESSION['userConnected']['id'];
    $sql = "SELECT * FROM users WHERE id != :i LIMIT 3";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':i', $current_user);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function getAllSuggestions() {
    global $conn;
    $current_user = $_SESSION['userConnected']['id'];
    $sql = "SELECT * FROM users WHERE id != :i";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':i', $current_user);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

//pour filtrer la liste des suggestions
function filterFollowSuggestion(){
    $list = getFollowSuggestions();
    $filter_list = array();
    foreach($list as $user) {
        if(!checkFollowStatus($user['id'])) {
            $filter_list[] = $user;
        }
    }
    return $filter_list;
}

//Pour voire si l'utilisateur est deja amis ou pas
function checkFollowStatus($id){
    global $conn;
    $current_user = $_SESSION['userConnected']['id'];    
    $sql = "SELECT COUNT(*) as ligne FROM amis WHERE user_id1 = :current_user AND user_id2 = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':current_user', $current_user);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC)['ligne'];
}


function createLike($user_id, $post_id) {
    global $conn;
    $sql = "INSERT INTO likes(nbrLike, post_id, user_id) VALUES(0, :pi, :ui)";
    $exe = $conn->prepare($sql);

    $exe->bindParam(':pi', $post_id);
    $exe->bindParam(':ui', $user_id);
    $result = $exe->execute();
    return $result;
   
}


function showOneComments($postId) {
    global $conn;

    $sql = "SELECT * FROM users as u, commentaires as c WHERE u.id = c.user_id AND c.post_id = :postId ORDER BY dateCommentaire DESC LIMIT 1;";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':postId', $postId);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function showAllComments($postId) {
    global $conn;

    $sql = "SELECT * FROM users as u, commentaires as c WHERE u.id = c.user_id AND c.post_id = :postId ORDER BY dateCommentaire DESC;";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':postId', $postId);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function delPost($idPost, $idUser){
    global $conn;
    $sql = "UPDATE posts SET statutUser = 0 WHERE posts.id = :idP AND posts.user_id = :idU;";
    $sql = $conn->prepare($sql);
    $sql->bindParam(':idP', $idPost);
    $sql->bindParam(':idU', $idUser);
    $sql->execute();
}

function blocked($idU, $idBl) {
    global $conn;
    $sql = "INSERT INTO blocked(user_id, userBlocked_id) VALUES(:iu, :ib)";
    $exe = $conn->prepare($sql);

    $exe->bindParam(':iu', $idU);
    $exe->bindParam(':ib', $idBl);
    $result = $exe->execute();
    return $result;
}

function unBlocked($idU, $idBl) {
    global $conn;
    $sql = "DELETE FROM blocked WHERE user_id = :iu AND userBlocked_id = :ib";
    $exe = $conn->prepare($sql);

    $exe->bindParam(':iu', $idU);
    $exe->bindParam(':ib', $idBl);
    $result = $exe->execute();
    return $result;
}

function verifBlock($idU, $idBl) {
    global $conn;
    $sql = "SELECT COUNT(*) FROM blocked WHERE user_id = :iu AND userBlocked_id = :ib";
    $exe=$conn->prepare($sql);
    $exe->bindParam(':iu', $idU);
    $exe->bindParam(':ib', $idBl);
    $exe->execute();

    $result = $exe->fetchColumn();
    
    return $result;
}
function isBlocked($idU, $idBl) {
    global $conn;
    $sql = "SELECT COUNT(*) FROM blocked WHERE user_id = :ib AND userBlocked_id = :iu";
    $exe=$conn->prepare($sql);
    $exe->bindParam(':iu', $idU);
    $exe->bindParam(':ib', $idBl);
    $exe->execute();

    $result = $exe->fetchColumn();
    
    return $result;
}

// function verifFollow($idU){
//     global  $conn;
//     $sql = "SELECT * FROM amis WHERE user_id2 = :id2";
//     $exe=$conn->prepare($sql);
//     $exe->bindParam(':id2', $idU);
//     $exe->execute();

//     $result = $exe->fetchAll(PDO::FETCH_ASSOC);
    
//     return $result;

// }
function createNotification($id, $msg){
    global $conn;
    $sql = "INSERT INTO notifications(user_id, messages) VALUES(:i, :m)";
    $exe = $conn->prepare($sql);

    $exe->bindParam(':i', $id);
    $exe->bindParam(':m', $msg);
    $result = $exe->execute();
    return $result;
}
function nombre_connection(){
    global $conn;
    $sql = "INSERT INTO nombre_connection() VALUES()";
    $exe = $conn->prepare($sql);
    $exe->execute();
}

function nombre_publication(){
    global $conn;
    $sql = "INSERT INTO nombre_publication() VALUES()";
    $exe = $conn->prepare($sql);
    $exe->execute();
}

function nombre_utilisateur(){
    global $conn;
    $sql = "INSERT INTO nombre_utilisateur() VALUES()";
    $exe = $conn->prepare($sql);
    $exe->execute();
}
// function nombre_utilisateur(){
//     global $conn;
    
//     // Récupérer le nombre d'utilisateurs dans la table
//     $sql_count = "SELECT COUNT(*) AS total_utilisateurs FROM votre_table";
//     $stmt = $conn->prepare($sql_count);
//     $stmt->execute();
//     $resultat = $stmt->fetch(PDO::FETCH_ASSOC);
//     $nombre_utilisateurs = $resultat['total_utilisateurs'];
    
//     // Insérer le nombre d'utilisateurs dans la table
//     $sql_insert = "INSERT INTO nombre_utilisateur(user) VALUES(:nombre_utilisateurs)";
//     $exe = $conn->prepare($sql_insert);
//     $exe->bindParam(':nombre_utilisateurs', $nombre_utilisateurs, PDO::PARAM_INT);
//     $exe->execute();
// }

// function nombre_publication(){
//     global $conn;
    
//     // Récupérer le nombre total de publications dans la table
//     $sql_count = "SELECT COUNT(*) AS total_publications FROM votre_table";
//     $stmt = $conn->prepare($sql_count);
//     $stmt->execute();
//     $resultat = $stmt->fetch(PDO::FETCH_ASSOC);
//     $nombre_publications = $resultat['total_publications'];
    
//     // Insérer le nombre total de publications dans la table
//     $sql_insert = "INSERT INTO nombre_publication(pub) VALUES(:nombre_publications)";
//     $exe = $conn->prepare($sql_insert);
//     $exe->bindParam(':nombre_publications', $nombre_publications, PDO::PARAM_INT);
//     $exe->execute();
// }

// function nombre_connection(){
//     global $conn;
    
//     // Récupérer le nombre total de connexions dans la table
//     $sql_count = "SELECT COUNT(*) AS total_connexions FROM votre_table";
//     $stmt = $conn->prepare($sql_count);
//     $stmt->execute();
//     $resultat = $stmt->fetch(PDO::FETCH_ASSOC);
//     $nombre_connexions = $resultat['total_connexions'];
    
//     // Insérer le nombre total de connexions dans la table
//     $sql_insert = "INSERT INTO nombre_connection(connection) VALUES(:nombre_connexions)";
//     $exe = $conn->prepare($sql_insert);
//     $exe->bindParam(':nombre_connexions', $nombre_connexions, PDO::PARAM_INT);
//     $exe->execute();
// }

function newBookmark($idPost, $idUser){
    global $conn;
    $sql = "INSERT INTO enregistrements(idPost, idUser) VALUES(:ip, :iu)";
    $exe = $conn->prepare($sql);

    $exe->bindParam(':ip', $idPost);
    $exe->bindParam(':iu', $idUser);
    $exe->execute();

}
function delBookmark($idPost, $idUser){
    global $conn;
    $sql = "DELETE FROM enregistrements WHERE idPost =:ip AND idUser = :iu";
    $exe = $conn->prepare($sql);

    $exe->bindParam(':ip', $idPost);
    $exe->bindParam(':iu', $idUser);
    $exe->execute();

}

function estEnregistreByUser($idPost, $idUser) {
    global $conn;
    $sql = "SELECT COUNT(*) FROM enregistrements WHERE idPost = :ip AND idUser = :iu";
    $exe = $conn->prepare($sql);
    $exe->bindParam(':ip', $idPost);
    $exe->bindParam(':iu', $idUser);
    $exe->execute();
    $result = $exe->fetchColumn();
    return $result;
}
function estAimeByUser($idPost, $idUser) {
    global $conn;
    $sql = "SELECT COUNT(*) FROM likes WHERE post_id = :ip AND user_id = :iu";
    $exe = $conn->prepare($sql);
    $exe->bindParam(':ip', $idPost);
    $exe->bindParam(':iu', $idUser);
    $exe->execute();
    $result = $exe->fetchColumn();
    return $result;
}

function saveByUser($id) {
    global $conn;
    $sql = $conn->prepare("SELECT p.id as postId, u.nom as nom, u.prenom as prenom, u.photoProfil as photoProfil, u.id as user_id,
                                  p.post_img as post_img, p.post_text as post_text,  p.dateCreate as dateCreate
                          FROM posts p, users u, enregistrements e
                          WHERE p.user_id = u.id AND p.id = e.idPost
                          AND p.statutAdmin = 1 AND p.statutUser = 1 AND e.idUser = :i
                          ORDER BY p.dateCreate DESC");
    $sql->bindParam(':i', $id);


    $sql->execute();
    $results = $sql->fetchAll(PDO::FETCH_ASSOC);
    return $results;



}
function numberSave($id){
    global $conn;
    $sql = "SELECT COUNT(*) FROM enregistrements WHERE idUser = :i";
    $exe = $conn->prepare($sql);
    $exe->bindParam(':i', $id);
    $exe->execute();
    $result = $exe->fetchColumn();
    return $result;
}

function addSignal($idPost, $idUser) {
    global $conn;
    $sql = "INSERT INTO signales(idPost, idUser) VALUES(:ip, :iu)";
    $exe = $conn->prepare($sql);

    $exe->bindParam(':ip', $idPost);
    $exe->bindParam(':iu', $idUser);
    $exe->execute();
}

function addNotification($id, $msg, $id_action="") {
    global $conn;
    $sql = "INSERT INTO notifications(user_id, messages, id_action) VALUES (:id, :msg, :idA)";
    $exe = $conn->prepare($sql);
    $exe->bindParam(':id', $id);
    $exe->bindParam(':msg', $msg);
    $exe->bindParam(':idA', $id_action);
    $exe->execute();
}

function getAllNotification($idUser){
    global $conn;
    $sql = $conn->prepare("SELECT u.nom nom, u.prenom prenom, u.photoProfil photoProfil, n.messages messages, n.id_action id_action, n.dateNotification dateNotification   FROM notifications n, users u  WHERE n.user_id = u.id AND n.user_id != :id");
    $sql->bindParam(':id', $idUser);
    $sql->execute();
    $results = $sql->fetchAll(PDO::FETCH_ASSOC);
    return $results;
}


function numberNotifications($id){
    global $conn;
    $sql = "SELECT COUNT(*) FROM notifications  WHERE user_id != :id";
    $exe = $conn->prepare($sql);
    $exe->bindParam(':id', $id);
    $exe->execute();
    $result = $exe->fetchColumn();
    return $result;
}

function sendMessage($idA, $idD, $msg) {
    global $conn;
    $sql ="INSERT INTO messages(idAuteur, idDestinataire, msg) VALUES(:idA, :idD, :msg)";
    
    $exe = $conn->prepare($sql);
    $exe->bindParam(':idA', $idA);
    $exe->bindParam(':idD', $idD);
    $exe->bindParam(':msg', $msg);
    $exe->execute();
}

function recupUser($id) {
    global $conn;

    $sql = $conn->prepare("SELECT * FROM users WHERE id = :i");
    $sql->bindParam(':i', $id);
    $sql->execute(); 
    $count = $sql->rowCount();
    return $count;
}

function recupMsg($idA, $idD){
    global $conn;
    $sql = $conn->prepare("SELECT m.*, u.photoProfil FROM messages m, users u WHERE m.idDestinataire = u.id AND (m.idAuteur =  :iA AND m.idDestinataire = :iD)");
    $sql->bindParam(':iA', $idA);
    $sql->bindParam(':iD', $idD);
    $sql->execute();
    $results = $sql->fetchAll(PDO::FETCH_ASSOC);
    return $results;
}

?>

