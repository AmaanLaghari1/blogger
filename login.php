<?php
session_start();

if(isset($_SESSION['uid'])){
    header("Location: ./user/home.php");
}

require_once "./db.php";



$email = $password = null;
$error = null;
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(empty($_POST['email'])){
        $error = "Email is required";
    }
    if(empty($_POST['pwd'])){
        $error = "Password is required";
    }
    elseif(empty($error)) {
        $email = cleanData($_POST['email']);
        $password = cleanData($_POST['pwd']);

        $hashedPwd = md5($password);

        echo $sql = "SELECT * FROM users WHERE email = '{$email}' and password = '{$hashedPwd}'";
        // die();
        $result = $con->query($sql);

        if($result->num_rows > 0){
            while($row = $result->fetch_object()){
                $_SESSION['uid'] = $row->id;
                $_SESSION['user-role'] = $row->role;
            }
            if($_SESSION['user-role'] == "admin"){
                header('Location: ./admin/home.php');
            }
            else {
                header('Location: ./user/home.php');
            }
            
        }
        else {
            $error = "Invalid credintials!";
        }
    }

}

require_once "./header.php"
?>
<div class="conatiner-fluid d-flex flex-column justify-content-center align-items-center text-light" id="Signup">
    <div class="my-2">
        <h1>Login</h1>
    </div>
    <form method="POST" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" class="col-6" novalidate>
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
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" name="email" id="email">
        </div>
        <div class="form-group my-2">
            <label for="pwd" class="form-label">Password</label>
            <input type="password" class="form-control" name="pwd" id="pwd">
        </div>
        <div class="mx-auto">
            <button class="btn btn-primary mx-auto">Login</button>
        </div>

        <p>Don't have an account? <a href="./signup.php" class="link">Signup</a></p>
    </form>
</div>

<?php
    require_once "./footer.php"
?>