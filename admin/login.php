<?php
session_start();
include('../class/database.php');
class signInUp extends database
{
    protected $link;

    public function signInFunction()
    {
        //Admin signIn
        if (isset($_POST['signIn'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $sql = "select * from admin where username = '$username' ";
            $res = mysqli_query($this->link, $sql);
            if (mysqli_num_rows($res) > 0) {
                $row = mysqli_fetch_assoc($res);
                $pass = $row['password'];
                if (password_verify($password, $pass) == true) {
                    $_SESSION['admin'] = $username;
                    header('location:index.php');
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
$objSignIn = $obj->signInFunction();



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
        <div class="container bg-white pr-4 pl-4 log_section pb-5">

            <div class="row">
                <div class="col-md-6 offset-3">
                    <form action="" method="post" data-parsley-validate>

                        <div class="text-center">
                            <h5 class="font-weight-bold pt-5">LOGIN</h5>
                            <p class="pt-4 pb-4">WELCOME ADMIN</p>
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
                                <strong>Wrong Credentials</strong>
                            </div>
                            <?php } ?>

                            <?php } ?>
                        </div>
                        <input type="text" name="username" class="form-control p-4  border-0 bg-light"
                            placeholder="Enter your username" required>
                        <input type="password" class="form-control mt-4 p-4 border-0 bg-light" name="password"
                            placeholder="Enter your password" required>
                        <button type="submit" name="signIn"
                            class="btn btn-block font-weight-bold log_btn btn-lg mt-4">LOGIN</button>

                    </form>
                </div>

                <!-- <form action="" method="post"> -->

                <!-- </form> -->
            </div>

        </div>

    </section>





    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>
</body>

</html>