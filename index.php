<?php

require_once "./db.php";

$email = $msg = null;
$error = $success = null;
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $email = cleanData($_POST['email']);
    $msg = cleanData($_POST['msg']);

    if(empty($email)){
        $error = "Email is required!";
    }
    else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $error = "Email format is incorrect!";
    }
    
    if(empty($msg)){
        $error = "Message is required!";
    }

    $sql = "INSERT INTO contacts (email, message) VALUES ('{$email}', '{$msg}')";

    $result = $con->query($sql);

    if($result){
        $success = "Message sent...";
    }
}

require_once "./header.php"
?>

<div id="Home" class="container-fluid d-flex justify-content-center align-items-center">

    <div class="d-flex flex-column text-light">
        <h1 class="display-1">Discover The Latest Trends In Blogging</h1>
        <p>
            Lorem ipsum dolor, sit amet consectetur adipisicing elit. Delectus dignissimos libero nihil vel exercitationem iusto numquam.
        </p>
        <button class="btn btn-primary rounded-0" style="width: 8rem;">Join Now</button>
    </div>

</div>

<div id="About" class="container-fluid d-flex justify-content-center align-items-center py-5">
    <div class="row">
        <div class="col-12 col-md-6 col-lg-6">
            <h1>About</h1>
            <p class="lead">
                Lorem ipsum dolor sit amet consectetur, adipisicing elit. Aut corrupti, obcaecati ipsa enim a quos fuga, suscipit neque aliquid nostrum quidem accusamus ratione officia consectetur porro libero veniam atque iusto!
                Suscipit repudiandae ut placeat? Veritatis, cupiditate repudiandae cumque debitis minima nihil placeat optio ex veniam exercitationem nobis adipisci sed natus quam? Perferendis eligendi quas nobis dolorum minus. Fugiat, accusantium laudantium?
            </p>
            <p class="lead">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Nemo, suscipit commodi. Odit officia alias sint! Doloribus in adipisci aliquid facilis cum vel, libero alias incidunt a! Deleniti sequi dolore at.
            </p>
        </div>
        <div class="col-12 col-md-6 col-lg-6">
            <img src="./static/images/bg.jpg" alt="" class="w-100">
        </div>
    </div>
</div>

<div id="Contact" class="container py-5 flex-column d-flex justify-content-center align-items-center">
    <h1>Contact Us</h1>
    <form method="POST" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" class="col-8" novalidate>
        <?php
            if(isset($success)){
                
        ?>
            <div class="alert alert-success"><?= $success ?></div>
        <?php
            }
            if(isset($error)){
        ?>
            <div class="text-danger">
                <?= $error ?>
            </div>
        <?php
            }
        ?>
        <div class="form-group my-2">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" name="email" id="email">
        </div>
        <div class="form-group my-2">
            <label for="msg" class="form-label">Message</label>
            <input type="text" class="form-control" name="msg" id="msg">
        </div>
        <button class="btn btn-primary">Send</button>
    </form>
</div>

<?php
require_once "./footer.php"
?>