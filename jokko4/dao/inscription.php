<?php
require_once 'connect_bd.php';
require_once 'fonctions.php';

//Pour creer nouveau utilisateur
function createUser($data) {
    global $conn;
    $stmt = $conn->query("SELECT COUNT(*) FROM users");
    $tableSize = $stmt->fetchColumn();

    // Utiliser la taille actuelle pour créer le nom d'utilisateur
    $username = $data['nom'] . $data['prenom'] . $tableSize;
    $code = rand(111111, 999999);
    sendCode($data['email'], "Verification Email", $code, $username);
    // Récupérer la taille actuelle de la table users
    $nom = htmlspecialchars($data['nom'], ENT_QUOTES, 'UTF-8');
    $prenom = htmlspecialchars($data['prenom'], ENT_QUOTES, 'UTF-8');
    $email = htmlspecialchars($data['email'], ENT_QUOTES, 'UTF-8');
    

    $sql = "INSERT INTO users(nom, prenom, sexe, email, password, username, codeValidation) VALUES (:n, :p, :s, :e, :pa, :u, :c)";
    $exe = $conn->prepare($sql);

    $exe->bindParam(':n', $nom);
    $exe->bindParam(':p', $prenom);
    $exe->bindParam(':s', $data['sexe']);
    $exe->bindParam(':e', $email);
    $passwordHash = md5($data['password']);
    $exe->bindParam(':pa', $passwordHash);
    $exe->bindParam(':u', $username);
    $exe->bindParam(':c', $code);

    // Exécution de l'insertion
    try {
        $result = $exe->execute();
        
        // Si l'insertion de l'utilisateur s'est bien passée
        // if($result) {
        //     // Insérer la relation d'amitié avec lui-même
        //     $userId = $conn->lastInsertId(); // Récupérer l'ID de l'utilisateur nouvellement inséré
        //     $sql_amis = "INSERT INTO amis (user_id1, user_id2, statut) VALUES (:u1, :u2, '2')";
        //     $exe_amis = $conn->prepare($sql_amis);
        //     $exe_amis->bindParam(':u1', $userId);
        //     $exe_amis->bindParam(':u2', $userId);
        //     $exe_amis->execute();
        // }

        return $result;
    } catch (PDOException $e) {
        echo "Erreur d'insertion : " . $e->getMessage();
        return false;
    }
}



?>