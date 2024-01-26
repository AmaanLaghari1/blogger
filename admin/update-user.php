<?php
session_start();

require_once "../db.php";

if(!isset($_SESSION['uid'])){
    header("Location: ../login.php");
}
if($_SESSION['user-role'] != "admin"){
    header("Location: ../login.php");
}
$userId = $_GET['id'];

$firstname = $lastname = $email = $password = $phone = $filename = null;
$error = $success = null;

// Images Handler 
if(isset($_FILES['uimage'])){
    $dir = "./users/uploads/profilepics/";

    $filename = $_FILES['uimage']['name'];
    $fileTmp = $_FILES['uimage']['tmp_name'];
    $fileSize = $_FILES['uimage']['size'];
    $fileType = $_FILES['uimage']['type'];

    if(empty($error)){
        move_uploaded_file($fileTmp, $dir . $filename);
    }
}

// Form Handler 
if($_SERVER['REQUEST_METHOD'] === "POST"){
    $firstname = cleanData($_POST['fname']);
    $lastname = cleanData($_POST['lname']);
    $email = cleanData($_POST['email']);
    $password = cleanData($_POST['pwd']);
    $phone = cleanData($_POST['phone']);
    $filename = cleanData($filename);

    $hashedPwd = md5($password);

    $sql = "UPDATE users SET firstname = '{$firstname}', lastname = '{$lastname}', email = '{$email}', password = '{$hashedPwd}', phone = '${phone}', uimage = '{$filename}' WHERE id = {$userId}";

    $result = $con->query($sql);

    if($result){
        $success = "User Updated Successfully...";
    }
}

require_once "./header.php";
?>

<div id="Dashboard" class="container-fluid">

    <h1 class="my-3 text-center">Update User</h1>

    <div class="col-8 mx-auto">
        <?php
            $sql = "SELECT * FROM users WHERE id = {$userId}";

            $result = $con->query($sql);

            if($result->num_rows > 0){
                while($row = $result->fetch_object()){
        ?>
        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>?id=<?= $userId ?>" method="POST" enctype="multipart/form-data">
            <div class="form-group my-2">
                <label for="" class="form-label">First Name</label>
                <input type="text" class="form-control" name="fname" value="<?= $row->firstname ?>">
            </div>
            <div class="form-group my-2">
                <label for="" class="form-label">Last Name</label>
                <input type="text" class="form-control" name="lname" value="<?= $row->lastname ?>">
            </div>
            <div class="form-group my-2">
                <label for="" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" value="<?= $row->email ?>">
            </div>
            <div class="form-group my-2">
                <label for="" class="form-label">Password</label>
                <input type="password" class="form-control" name="pwd" value="<?= $row->password ?>">
            </div>
            <div class="form-group my-2">
                <label for="" class="form-label">Phone</label>
                <input type="number" class="form-control" name="phone" value="<?= $row->phone ?>">
            </div>
            <div class="form-group my-2">
                <label for="" class="form-label">Profile Picture (jpg, png)</label>
                <input type="file" class="form-control" name="uimage">
            </div>
            <img src="../user/uploads/profilepics/<?= $row->uimage ?>" alt="" class="thumbnail-img d-block my-2">
            <button class="btn btn-primary">Save</button>
        </form>
        <?php

                }
            }
        ?>

        
    </div>
    

</div>



<?php
require_once "./footer.php"
?>