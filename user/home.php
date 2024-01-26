<?php
session_start();

if(!isset($_SESSION['uid'])){
    header("Location: ./login.php");
}

require_once "../db.php";
require_once "./header.php";
?>

<div id="Dashboard" class="container-fluid">

    <h1 class="my-3">Most Recent Posts</h1>
    <a href="./addblog.php" class="text-decoration-none">
        <button class="btn btn-outline-primary">Create Your Blog</button>
    </a>
    <div class="row">
        <?php
            $sql = "SELECT b.id, b.title, b.description, b.image, u.email FROM blogs b INNER JOIN users u ON b.author = u.id";
            
            $result = $con->query($sql);

            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
        ?>


    <div class="col-12 col-sm-12 col-md-4 p-3">
            <img src="./uploads/<?= $row['image'] ?>" class="img-fluid w-100" />
        </div>
        <div class="col-12 col-sm-12 col-md-8 p-3">
            <div class="d-flex flex-column">
                <h3 class="display-2">
                <?php
                if(strlen($row['title']) > 20){
                    echo substr_replace($row['title'], '...', 20);
                }
                else {
                    echo $row['title'];
                }
                 ?>
                 </h3>
                <p class="lead">
                <?php
                if(strlen($row['description']) > 250){
                    echo substr_replace($row['description'], '...', 250);
                }
                else {
                    echo $row['description'];
                }
                 ?>
                </p>
                <div class="text-muted"><?= $row['email'] ?></div>
                <div class="my-2">
                    <a class="text-decoration-none" href="./blogdetails.php?id=<?= $row['id'] ?>">
                        <button class="btn btn-warning">Read More</button>
                    </a>
                </div>
            </div>
        </div>

        <?php
                }
            }

            else {
        ?>
            <p class="lead text-center my-5">No Blogs to show!</p>
        <?php
            }
        ?>
        
    </div>

</div>

<?php
require_once "./footer.php"
?>