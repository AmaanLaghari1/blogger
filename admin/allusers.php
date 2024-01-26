<?php
session_start();

if(!isset($_SESSION['uid'])){
    header("Location: ../login.php");
}
if($_SESSION['user-role'] != "admin"){
    header("Location: ../login.php");
}

require_once "../db.php";
require_once "./header.php";
?>

<div id="Dashboard" class="container-fluid">

    <h1 class="my-3">All Users</h1>
    <a href="../user/addblog.php" class="text-decoration-none">
        <button class="btn btn-outline-primary">Create New User</button>
    </a>

    <table class="table table-striped my-2">
        <tr>
            <th>ID</th>
            <th>FIRSTNAME</th>
            <th>LASTNAME</th>
            <th>EMAIL</th>
            <th>PHONE</th>
            <th>ROLE</th>
            <th>PROFILEPIC</th>
            <th class="col-1">ACTIONS</th>
        </tr>

        <?php
            $sql = "SELECT * FROM users";

            $result = $con->query($sql);

            if($result->num_rows > 0){
                while($row = $result->fetch_object()){

        ?>
            <tr>
                <td><?= $row->id ?></td>
                <td><?= $row->firstname ?></td>
                <td><?= $row->lastname ?></td>
                <td><?= $row->email ?></td>
                <td><?= $row->phone ?></td>
                <td><?= $row->role ?></td>
                <td><?= $row->uimage ?></td>
            
                
            <td>
                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#dltBlog<?= $row->id ?>">
                        Delete
                    </button>
                    <a href="./update-user.php?id=<?= $row->id ?>" class="text-decoration-none">
                        <button class="btn btn-success btn-sm mx-1">Update</button>
                    </a>
                </td>
            </tr>

            <!-- Button trigger modal -->
            

            <!-- Modal -->
            <div class="modal fade" id="dltBlog<?= $row->id ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure to delete this user?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                    <form action="../user/delete-blog.php" method="post">
                        <input type="hidden" name="blog-id" value="<?= $row->id ?>" />
                        <button class="btn btn-danger btn-sm" type="submit">Confirm</button>
                    </form>
                </div>
                </div>
            </div>
            </div>

        <?php
                }
            }
            else {
        ?>
            <tr>
                <th class="text-center" colspan="8">No users to show!</th>
            </tr>
        <?php
            }
        ?>
    </table>

</div>



<?php
require_once "./footer.php"
?>