<?php
require_once "../db.php";

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $contactId = $_POST['contact-id'];

    $sql = "DELETE FROM contact WHERE id = {$contactId}";

    $foreignKeyDisable = "SET FOREIGN_KEY_CHECKS=0";

    $con->query($foreignKeyDisable);
    
    if($con->query($sql)){
        header("Location: ./contact.php");
    }

    $foreignKeyDisable = "SET FOREIGN_KEY_CHECKS=1";

    $con->query($foreignKeyDisable);
}