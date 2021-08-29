<?php
session_start();
include('class/database.php');
class signInUp extends database
{
    protected $link;
    public function signUpFunction()
    {
        if (isset($_POST['signup'])) {
            //addslashes take different ascii value and trim will remove start and last white space
            $fname = addslashes(trim($_POST['fname']));
            $lname = addslashes(trim($_POST['lname']));
            $email = addslashes(trim($_POST['email']));
            $phone = addslashes(trim($_POST['phone']));
            $pass = trim($_POST['password']);

            //This will hash the password
            $password = password_hash($pass, PASSWORD_DEFAULT);

            $sql = "select * from user_tbl where email = '$email'";
            $res = mysqli_query($this->link, $sql);
            if (mysqli_num_rows($res) > 0) {
                $msg = "Email taken";
                return $msg;
            } else {
                $sql2 = "INSERT INTO `user_tbl` (`id`, `fname`, `lname`, `email`, `phone`, `password`, `created`) VALUES (NULL, '$fname', '$lname', '$email', '$phone', '$password', CURRENT_TIMESTAMP)";
                $res2 = mysqli_query($this->link, $sql2);
                if ($res2) {
                    $img = "placeholder-16-9.jpg";
                    $sql3 = "INSERT INTO `user_info` (`id`, `email`, `phone`, `country`, `city`, `image`, `created`, `updated`) VALUES (NULL, '$email', '$phone', '', '', '$img', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)";
                    mysqli_query($this->link, $sql3);
                    //This session['email'] variable will be accessed by all session_start()
                    $_SESSION['email'] = $email;
                    //header function will redirect the user to profile.php page
                    header('location:profile.php');
                    $msg = "Added";
                    return $msg;
                } else {
                    $msg = "Not Added";
                    return $msg;
                }
            }
        }
        # code...
    }
    public function signInFunction()
    {
        if (isset($_POST['signIn'])) {
            $email = $_POST['emailLogIn'];
            $password = $_POST['passwordLogIn'];

            $sql = "select * from user_tbl where email = '$email' ";
            $res = mysqli_query($this->link, $sql);
            if (mysqli_num_rows($res) > 0) {
                $row = mysqli_fetch_assoc($res);
                $pass = $row['password'];
                //password verify will check the hashed password from database and match with users password
                if (password_verify($password, $pass) == true) {
                    $_SESSION['email'] = $email;
                    header('location:profile.php');
                    return $res;
                } else {
                    $msg = "Wrong password";
                    return $msg;
                }
            } else {
                $msg = "Invalid Information";
                return $msg;
            }
        }
        # code...
    }
}
$obj = new signInUp;
$objSignUp = $obj->signUpFunction();
$objSignIn = $obj->signInFunction();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amazing Burgers</title>
    <?php include('layout/style.php'); ?>
    <link
        href="https://fonts.googleapis.com/css2?family=Abril+Fatface&family=Alfa+Slab+One&family=Anton&family=Bungee&family=Fredoka+One&family=Limelight&display=swap"
        rel="stylesheet">
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
    <?php include('layout/navbar.php'); ?>

    <h2 class=" text-center wow tada mt-5" style="font-family: 'Alfa Slab One', cursive;">Welcome to Amazing Burgers!!
    </h2>
    <section>
        <div class="container bg-white pr-4 pl-4 log_section pb-5">

            <div class="row">
                <div class="col-md-5">
                    <form action="" method="post" data-parsley-validate>

                        <div class="text-center">
                            <h5 class="font-weight-bold pt-5">LOGIN</h5>
                            <p class="pt-4 pb-4">Already Have an Account?</p>
                            <?php if ($objSignIn) { ?>
                            <?php if (strcmp($objSignIn, 'Wrong password') == 0) { ?>
                            <div class="alert alert-danger alert-dismissible fade show">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <strong>Wrong Password!</strong>
                            </div>
                            <?php } ?>
                            <?php if (strcmp($objSignIn, 'Invalid Information') == 0) { ?>
                            <div class="alert alert-warning alert-dismissible fade show">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <strong>Please Sign Up!</strong>
                            </div>
                            <?php } ?>

                            <?php } ?>
                        </div>
                        <input type="email" name="emailLogIn" class="form-control p-4  border-0 bg-light"
                            placeholder="Enter your email address" required>
                        <input type="password" class="form-control mt-4 p-4 border-0 bg-light" name="passwordLogIn"
                            placeholder="Enter your password" required>
                        <button type="submit" name="signIn"
                            class="btn btn-block font-weight-bold log_btn btn-lg mt-4">LOGIN</button>

                    </form>
                </div>
                <div class="col-md-2 text-center">
                    <div class="vertical_line text-center mx-auto"></div>
                </div>
                <!-- <form action="" method="post"> -->
                <div class="col-md-5">
                    <form action="" method="post" data-parsley-validate>

                        <div class="text-center">
                            <h5 class="font-weight-bold pt-5">SIGNUP</h5>
                            <p class="pt-4 pb-4">Don't have an Account?</p>
                            <?php if ($objSignUp) { ?>
                            <?php if (strcmp($objSignUp, 'Email taken') == 0) { ?>
                            <div class="alert alert-warning alert-dismissible fade show">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <strong>Email is already taken!</strong>
                            </div>
                            <?php } ?>
                            <?php if (strcmp($objSignUp, 'Email taken') == 1) { ?>
                            <div class="alert alert-warning alert-dismissible fade show">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <strong>Invalid Information!</strong>
                            </div>
                            <?php } ?>
                            <?php if (strcmp($objSignUp, 'Added') == 0) { ?>
                            <div class="alert alert-success alert-dismissible fade show">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <strong>Congratulation!</strong> Profile is created!
                            </div>
                            <?php } ?>

                            <?php } ?>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mt-4"><input name="fname" type="text"
                                    class="form-control p-4 border-0 bg-light" placeholder="Firstname" required></div>
                            <div class="col-md-6 mt-4"><input name="lname" type="text"
                                    class="form-control p-4 border-0 bg-light" placeholder="Lastname" required></div>
                        </div>
                        <input type="email" name="email" class="form-control mt-4 p-4 border-0 bg-light"
                            placeholder="Email Address" required>
                        <input type="text" name="phone" class="form-control mt-4 p-4 border-0 bg-light"
                            placeholder="Phone Number" data-parsley-maxlength="11" data-parsley-minlength="11"
                            data-parsley-type="digits" required>
                        <input type="password" id="passwordField" class="form-control mt-4 p-4 border-0 bg-light"
                            placeholder="Password" data-parsley-minlength="6" required>
                        <input data-parsley-equalto="#passwordField" type="password"
                            class="form-control mt-4 p-4 border-0 bg-light" name="password"
                            placeholder="Confirm Password" required>
                        <button name="signup" type="submit"
                            class="btn btn-block font-weight-bold log_btn btn-lg mt-4">SIGNUP</button>
                    </form>
                </div>
                <!-- </form> -->
            </div>

        </div>
        <div id="goTop"></div>


    </section>

    <?php include('layout/footer.php'); ?>


    <?php include('layout/script.php') ?>
</body>

</html>