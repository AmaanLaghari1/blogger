<?php
session_start();

require_once "../db.php";

if($_SERVER['REQUEST_METHOD'] === "POST"){
    $blogId = $_POST['blog-id'];

    $sql = "DELETE FROM blogs WHERE id = {$blogId}";

    $result = $con->query($sql);

    if($result){
        if($_SESSION['user-role'] == "admin"){
            header("Location: ../admin/home.php");
        }
        else {
            header("Location: ./userprofile.php");
        }
    }
}