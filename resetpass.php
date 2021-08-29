<?php
session_start();
if (isset($_SESSION['email'])) {
} else {
    header('location:signInUp.php');
}
include('class/database.php');
class profile extends database
{
    protected $link;
    public function showProfile()
    {
        $email = $_SESSION['email'];
        $sql = "select * from user_tbl where email = '$email' ";
        $res = mysqli_query($this->link, $sql);

        if (mysqli_num_rows($res) > 0) {
            return $res;
        } else {
            return false;
        }
        # code...
    }
    public function passwordFunction()
    {
        if (isset($_POST['upload'])) {
            $pass = $_POST['confirm_password'];
            $email = $_SESSION['email'];
            $password = password_hash($pass, PASSWORD_DEFAULT);

            $sql = "UPDATE `user_tbl` SET `password`= '$password' WHERE email = '$email' ";
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
$obj = new profile;
$objShow = $obj->showProfile();
$objPass = $obj->passwordFunction();
$row = mysqli_fetch_assoc($objShow);




?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php include('layout/style.php'); ?>
    <style>
    .profileImage {
        height: 200px;
        width: 200px;
        object-fit: cover;
        border-radius: 50%;
        margin: 10px auto;
        cursor: pointer;

    }

    .upload_btn {
        background-color: #EEA11D;
        color: #481639;
        transition: 0.7s;
    }

    .upload_btn:hover {
        background-color: #481639;
        color: #EEA11D;
    }

    .navbar-brand {
        width: 20%;
    }

    .bg_color {
        background-color: #FCF4ED !important;
    }


    body {
        font-family: 'Lato', sans-serif;
    }
    </style>

</head>

<body class="bg-light">
    <?php include('layout/navbar.php'); ?>


    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-2">
                    <h3 class="float-left font-weight-bold" style="color: #481639">Dashboard</h3>
                    <a href="profile.php" class="pt-5 mt-5 font-weight-normal text-dark  d-block"
                        style="text-decoration: none;">Profile</a>

                    <hr>
                    <a href="notification.php" class=" font-weight-normal text-dark  d-block"
                        style="text-decoration: none;">Order History</a>

                    <hr>
                    <a href="resetpass.php" class=" font-weight-normal text-dark font-weight-bold  d-block"
                        style="text-decoration: none;">Reset
                        Password</a>
                    <hr>


                    <a href="logout.php" class="mb-5 font-weight-normal text-dark  d-block"
                        style="text-decoration: none;">Logout</a>
                </div>
                <div class="col-md-10">
                    <h3 class="float-right d-block font-weight-bold" style="color: #481639"><span
                            class="text-secondary font-weight-light">Welcome |</span>
                        <?php echo $row['fname'] ?>
                        <?php echo $row['lname']; ?></h3>

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
        <div id="goTop"></div>

    </section>

    <?php include('layout/footer.php'); ?>


    <?php include('layout/script.php') ?>
</body>

</html>