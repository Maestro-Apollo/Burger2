<?php
session_start();
if (isset($_SESSION['admin'])) {
} else {
    header('location:login.php');
}
include('../class/database.php');
class signInUp extends database
{
    protected $link;

    public function passwordFunction()
    {
        //This function will reset admin password
        if (isset($_POST['upload'])) {
            $pass = $_POST['confirm_password'];
            $user = $_SESSION['admin'];
            $password = password_hash($pass, PASSWORD_DEFAULT);

            $sql = "UPDATE `admin` SET `password`= '$password' WHERE username = '$user' ";
            $res = mysqli_query($this->link, $sql);
            if ($res) {
                $msg = "Updated";
                return $msg;
            } else {
                $msg = "not update";
                return $msg;
            }
        }
        # code...
    }
}
$obj = new signInUp;
$objPass = $obj->passwordFunction();



?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="Description" content="Enter your description here" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <title>Title</title>
    <style>
    body {
        font-family: 'Lato', sans-serif;

    }

    .navbar-brand {
        width: 20%;
    }

    .bg_color {
        background-color: #FCF4ED !important;
    }
    </style>
</head>

<body class="bg-light">

    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-2">
                    <h3 class="float-left font-weight-bold" style="color: #481639">Dashboard</h3>
                    <a href="index.php" class="pt-5 mt-5 font-weight-normal text-dark  d-block"
                        style="text-decoration: none;">Dashboard</a>

                    <hr>

                    <a href="add.php" class=" font-weight-normal text-dark   d-block" style="text-decoration: none;">Add
                        Food</a>
                    <hr>
                    <a href="resetpass.php" class=" font-weight-normal text-dark font-weight-bold  d-block"
                        style="text-decoration: none;">Reset
                        Password</a>
                    <hr>


                    <a href="logout.php" class="mb-5 font-weight-normal text-dark  d-block"
                        style="text-decoration: none;">Logout</a>
                </div>
                <div class="col-md-10">


                    <div class="account bg-white mt-5 p-5 rounded">
                        <h4 class="font-weight-bold" style="color: #481639">Change Password</h4>
                        <form action="" method="post" data-parsley-validate>
                            <div class="row mt-4">
                                <div class="col-md-7">
                                    <?php if ($objPass) { ?>
                                    <?php if (strcmp($objPass, 'Updated') == 0) { ?>
                                    <div class="alert alert-success alert-dismissible fade show">
                                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                                        <strong>Password Changed!</strong>
                                    </div>
                                    <?php } ?>
                                    <?php if (strcmp($objPass, 'Updated') == 1) { ?>
                                    <div class="alert alert-warning alert-dismissible fade show">
                                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                                        <strong>Invalid Information!</strong>
                                    </div>
                                    <?php } ?>

                                    <?php } ?>
                                    <label class="font-weight-bold mt-4" for="new_pass">New Password</label>
                                    <input data-parsley-minlength="6" type="password" id="new_pass" name="new_password"
                                        class="bg-light form-control border-0" required>
                                    <label class="font-weight-bold mt-4" for="confirm_pass">Confirm New Password</label>
                                    <input type="password" id="confirm_pass" name="confirm_password"
                                        data-parsley-equalto="#new_pass" class="bg-light form-control border-0"
                                        required>
                                </div>
                                <div class="col-md-5"></div>
                            </div>
                            <button class="btn font-weight-bold log_btn btn-lg mt-5" type="submit"
                                name="upload">Confirm</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>





    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>
</body>

</html>