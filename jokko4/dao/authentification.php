<?php

require_once 'connect_bd.php';

function connection($login, $mdp)
{
    $sql = "SELECT *
         FROM users u 
         WHERE username ='$login' 
         AND password ='$mdp'";
    global $conn; 
    $exe = $conn->query($sql); 
    $result  = $exe->fetch();
    return $result; 
}