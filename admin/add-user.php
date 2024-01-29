<?php
session_start();

require_once "../db.php";

if(!isset($_SESSION['uid'])){
    header("Location: ../login.php");
}
if($_SESSION['user-role'] != "admin"){
    header("Location: ../login.php");
}

$firstname = $lastname = $email = $password = $phone = $filename = null;
$error = $success = null;

// Images Handler 
if(isset($_FILES['uimage'])){
    $dir = "../user/uploads/profilepics/";

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
    $role = $_POST['role'];

    $hashedPwd = md5($password);

    
        $sql = "INSERT INTO users (firstname, lastname, email, password, phone, uimage, role) VALUES ('{$firstname}', '{$lastname}', '{$email}', '{$hashedPwd}', '{$phone}', '{$filename}', '{$role}')";
    

    $result = $con->query($sql);

    if($result){
        $success = "User Added Successfully...";
    }
}

require_once "./header.php";
?>

<div id="Dashboard" class="container-fluid">

    <h1 class="my-3 text-center">Add New User</h1>

    <?php
        if(isset($success)){
    ?>
        <div class="alert alert-success">
            <?= $success ?>
        </div>
    <?php
        }
    ?>
    <div class="col-8 mx-auto">
        
        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST" enctype="multipart/form-data">
            <div class="form-group my-2">
                <label for="" class="form-label">First Name</label>
                <input type="text" class="form-control" name="fname">
            </div>
            <div class="form-group my-2">
                <label for="" class="form-label">Last Name</label>
                <input type="text" class="form-control" name="lname">
            </div>
            <div class="form-group my-2">
                <label for="" class="form-label">Email</label>
                <input type="email" class="form-control" name="email">
            </div>
            <div class="form-group my-2">
                <label for="" class="form-label">Password</label>
                <input type="password" class="form-control" name="pwd" >
            </div>
            <div class="form-group my-2">
                <label for="" class="form-label">Phone</label>
                <input type="number" class="form-control" name="phone" >
            </div>
            <div class="form-group my-2">
                <label for="">User Role</label>
                <select name="role" id="">
                    <option value="primary">Primary</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <div class="form-group my-2">
                <label for="" class="form-label">Profile Picture (jpg, png)</label>
                <input type="file" class="form-control" name="uimage">
            </div>
            <button class="btn btn-primary">Save</button>
        </form>

        
    </div>
    

</div>



<?php
require_once "./footer.php"
?>