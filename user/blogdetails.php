<?php
session_start();

if(!isset($_SESSION['uid'])){
    header("Location: ./login.php");
}

require_once "../db.php";
require_once "./header.php"
?>

<div id="Dashboard" class="container-fluid">

    <h1 class="my-3">Blog Details</h1>
    <div class="row">
        <?php
            $sql = "SELECT b.id, b.title, b.description, b.image, u.email FROM blogs b INNER JOIN users u ON b.author = u.id WHERE b.id = {$_GET['id']}";

            $result = $con->query($sql);

            if($result->num_rows > 0){
                while($row = $result->fetch_object()){
            ?>

                    <div class="col-12 p-3">
                        <img src="./uploads/<?= $row->image ?>" class="img-fluid blog-img w-100" />
                    </div>
                    <div class="col-12 p-3">
                        <div class="d-flex flex-column">
                            <h3 class="display-2"><?= $row->title ?></h3>
                            <div class="text-muted"><?= $row->email ?></div>
                            <p class="lead">
                                <?= $row->description ?>
                            </p>
                            <div class="my-2">
                                <a href="./home.php" class="text-decoration-none">
                                    <button class="btn btn-primary">Go Back</button>
                                </a>
                            </div>
                        </div>
                    </div>

            <?php
                }
            }
            ?>
        
    </div>

</div>

<?php
require_once "./footer.php"
?>