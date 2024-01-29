<?php
require_once "../db.php";

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $userId = $_POST['user-id'];

    $sql = "DELETE FROM users WHERE id = {$userId}";

    $foreignKeyDisable = "SET FOREIGN_KEY_CHECKS=0";

    $con->query($foreignKeyDisable);
    
    if($con->query($sql)){
        header("Location: ./allusers.php");
    }

    $foreignKeyDisable = "SET FOREIGN_KEY_CHECKS=1";

    $con->query($foreignKeyDisable);
}