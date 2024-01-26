<?php
session_start();

if(!isset($_SESSION['uid'])){
    header("Location: ./login.php");
}

require_once "../db.php";

$title = $desc = $fileName = null;
$success = $error = null;
if($_SERVER['REQUEST_METHOD'] === 'POST'){

    if(empty($_POST['title'])){
        $error = "Title is required!";
    }
    if(empty($_POST['desc'])){
        $error = "Description is required!";
    }

    if(isset($_FILES['image'])){
        $dir = "uploads/";
        
        $fileName = $_FILES['image']['name'];
        $fileSize = $_FILES['image']['size'];
        $fileTmp = $_FILES['image']['tmp_name'];
        $fileType = $_FILES['image']['type'];

        if($fileSize > 2000000){
            $error = "File size limit exceed...";
        }

        if(empty($error)){
            if(move_uploaded_file($fileTmp, $dir . $fileName)){
                // $success = "File Uploaded...";
            }
        }

    if(empty($error)){
        $title = cleanData($_POST['title']);
        $desc = cleanData($_POST['desc']);
        $authorId = $_SESSION['uid'];
        $fileName = cleanData($fileName);

        $sql = "INSERT INTO blogs (title, description, image, author) VALUES ('{$title}', '{$desc}', '{$fileName}', {$authorId})";
        // die();
        $result = $con->query($sql);
    
        if($result){
            $success = "Blog created successfully...";
        }
    }


    }
}


    require_once "./header.php"
?>

<div class="conatiner-fluid d-flex flex-column justify-content-center align-items-center text-light" id="Signup">
    <div class="my-2">
        <h1 class="display-2">Create a new blog</h1>
    </div>
    <form method="POST" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" class="col-6" enctype="multipart/form-data" novalidate>
        <?php
            if(isset($success)){
                
        ?>
            <div class="alert alert-success"><?= $success ?></div>
        <?php
            }
            if(isset($error)){
        ?>
            <div class="alert alert-danger">
                <?= $error ?>
            </div>
        <?php
            }
        ?>
        <div class="form-group my-2">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" name="title" id="title">
        </div>
        <div class="form-group my-2">
            <label for="desc" class="form-label">Description</label>
            <textarea class="form-control" name="desc" id="desc"></textarea>
        </div>
        <div class="form-group my-2">
            <label for="image" class="form-label">Image</label>
            <input type="file" class="form-control" name="image" id="image">
        </div>
            <button class="btn btn-primary">Save</button>
    </form>
</div>

<?php
    require_once "./footer.php"
?>