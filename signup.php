<?php
session_start();

if(isset($_SESSION['uid'])){
    header("Location: ./user/home.php");
}

require_once "./db.php";

$cpassword = $email = $password = $firstname = $lastname = $phone = null;
$success = $error = null;
if($_SERVER['REQUEST_METHOD'] === 'POST'){

    if(empty($_POST['fname'])){
        $error = "Firstname is required!";
    }

    if(empty($_POST['lname'])){
        $error = "Lastname is required!";
    }

    if(empty($_POST['phone'])){
        $error = "Phone Number is required!";
    }
    // echo $_POST['phone'];
    // die();
    elseif(strlen($_POST['phone']) !== 11){
        $error = "Phone number should be 11 digits!";
    }
    
    if(empty($_POST['email'])){
        $error = "Email is required!";
    }
    else {
        $email = cleanData($_POST['email']);
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $error = "Email is incorrect!";
        }
        $query = "SELECT id FROM users WHERE email = '{$email}'";
        $result = $con->query($query);
        if($result->num_rows > 0){
            $error = "Email already exists!";
        }
    }
    if(empty($_POST['pwd'])){
        $error = "Password is required!";
    }
    else if($_POST['pwd'] !== $_POST['cpwd']){
        $error = "Passwords doesn't match!";
    }
    else if(empty($error)) {
        $password = cleanData($_POST['pwd']);
        $email = cleanData($_POST['email']);
        $firstname = cleanData($_POST['fname']);
        $lastname = cleanData($_POST['lname']);
        $phone = cleanData($_POST['phone']);
        $hashedPwd = md5($password);

        $query = "INSERT INTO users (firstname, lastname, email, password, phone) VALUES ('{$firstname}', '{$lastname}', '{$email}', '{$hashedPwd}', '{$phone}')";
    
        $result = $con->query($query);
    
        if($result){
            $success = "Account Created Successfully...";
        }
    }


    
}



    require_once "./header.php"
?>

<div class="conatiner-fluid d-flex flex-column justify-content-center align-items-center text-light" id="Signup">
    <div class="my-2">
        <h1>Sign Up</h1>
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
            <label for="fname" class="form-label">First Name</label>
            <input type="text" class="form-control" name="fname" id="fname">
        </div>
        <div class="form-group my-2">
            <label for="lname" class="form-label">Last Name</label>
            <input type="text" class="form-control" name="lname" id="lname">
        </div>
        <div class="form-group my-2">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" name="email" id="email">
        </div>
        <div class="form-group my-2">
            <label for="pwd" class="form-label">Password</label>
            <input type="password" class="form-control" name="pwd" id="pwd">
        </div>
        <div class="form-group my-2">
            <label for="cpwd" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" name="cpwd" id="cpwd">
        </div>
        <div class="form-group my-2">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" class="form-control" name="phone" id="phone">
        </div>
        <div class="mx-auto">
            <button class="btn btn-primary mx-auto">Sign Up</button>
        </div>

        <p>Already have an account? <a href="./login.php" class="link">Login</a></p>
    </form>
</div>

<?php
    require_once "./footer.php"
?>