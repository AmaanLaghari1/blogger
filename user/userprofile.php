<?php
session_start();

if(!$_SESSION['uid']){
    header("Location: ../login.php");
}

require_once "../db.php";


$error = null;
if(isset($_FILES['user-img'])){
        $dir = "uploads/profilepics/";
        
        $fileName = $_FILES['user-img']['name'];
        $fileSize = $_FILES['user-img']['size'];
        $fileTmp = $_FILES['user-img']['tmp_name'];
        $fileType = $_FILES['user-img']['type'];

        if($fileSize > 2000000){
            $error = "File size limit exceed...";
        }

        if(empty($error)){
            move_uploaded_file($fileTmp, $dir . $fileName);
        }

        $sql = "UPDATE users SET uimage = '{$fileName}' WHERE id = {$_SESSION['uid']}";
        $con->query($sql);
        
}

require_once "./header.php";
?>

<h1>User Profile</h1>

<div class="container">
    <div class="row">
        <?php
            $sql = "SELECT * FROM users WHERE id = {$_SESSION['uid']}";
            $result = $con->query($sql);
            if($result->num_rows > 0){
                while($row = $result->fetch_object()){

        ?>
                <div class="col-12 col-sm-12 col-md-3" >
        <img style="height: 20rem; width: 20rem;" src="
        <?php
        if($row->uimage == "no image"){

            echo "./uploads/profilepics/dummy-image.png";
        }
        else {
            echo "./uploads/profilepics/{$row->uimage}";
        }
        ?>
        " alt="" class="img-fluid" />

        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST" enctype="multipart/form-data">
            <input type="file" class="form-control" name="user-img">
            <button type="submit" class="btn btn-sm btn-success">Upload</button>
        </form>
    </div>
    <div class="col-12 col-sm-12 col-md-8">
        
        <table class="table table-dark">
            <tr>
                <th>
                    First Name
                </th>
                <td>
                    <?= $row->firstname ?>
                </td>
            </tr>
                <th>
                Last Name
                </th>
                <td>
                    <?= $row->lastname ?>
                </td>
            </tr>
                <th>
                    Email
                </th>
                <td>
                    <?= $row->email ?>
                </td>
            </tr>
                <th>
                    Password
                </th>
                <td>
                    <?= $row->password ?>
                </td>
            </tr>
                <th>
                    Phone 
                </th>
                <td>
                    <?= $row->phone ?>
                </td>
            </tr>
        </table>
    </div>


        <?php
                }
            }
        ?>
    
    </div>
</div>

<div class="container my-3">
    <h1>Your Blogs</h1>
    <div class="d-flex justify-content-center flex-wrap p-2">

    <?php

        $sql = "SELECT * FROM blogs WHERE author = {$_SESSION['uid']}";

        $result = $con->query($sql);

        if($result->num_rows > 0){
            while($row = $result->fetch_object()){

    ?>
        <div class="card" style="width: 22rem;">
            <img src="./uploads/<?= $row->image ?>" alt="" class="card-img-top">
            <div class="card-body">
                <h5 class="card-title"><?= $row->title ?></h5>
                <div class="card-text">
                <?php
                if(strlen($row->description) > 25){
                    echo substr_replace($row->description, '...', 25);
                }
                else {
                    echo $row->description;
                }
                 ?>
                </div>

                <form action="./delete-blog.php" method="post">
                    <input type="hidden" value="<?= $row->id ?>" name="blog-id">
                    <button type="submit" name="dlt-blog" class="btn btn-danger btn-sm my-2">Delete</button>
                </form>
                <a href="./update-blog.php?id=<?= $row->id ?>" class="btn btn-success btn-sm">Update</a>
            </div>
        </div>

    <?php
            }
        }
        else {
    ?>
        <p class="lead text-center">You don't have any blogs!</p>
    <?php
        }
    ?>
        
    </div>
</div>