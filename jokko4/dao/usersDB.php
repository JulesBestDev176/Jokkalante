<?php
function getUserById($id) {
    global $conn;
    $sql = "SELECT * FROM users WHERE id = $id";
    $exe = $conn->query($sql);
    $result = $exe->fetch();
    return $result;
}
?>