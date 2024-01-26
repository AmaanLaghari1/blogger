
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blogger</title>
    <link rel="stylesheet" href="../static/css/bootstrap.css">
    <link rel="stylesheet" href="../static/css/style.css">
</head>
<body>
    
<nav class="navbar navbar-expand-lg bg-primary navbar-dark p-3">
  <div class="container-fluid">
    <a class="navbar-brandm text-light text-decoration-none fs-5" href="#">
        <img src="../static/images/logo_maker_design_app01.jpg" alt="" class="w-25" style="height: 50px;"> Blogger - <i>Admin Panel</i>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="./home.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="./allusers.php">Users</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="../user/home.php">User Panel</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="../logout.php">Logout</a>
        </li>
        
        <?php
          if(!isset($_SESSION['uid'])){
        ?>
          <li class="nav-item">
            <a class="nav-link" href="./signup.php">Sign Up</a>
          </li>
        <?php
          }
        ?>
      </ul>
    </div>
  </div>
</nav>