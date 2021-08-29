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

    public function showProfileInfo()
    {
        $email = $_SESSION['email'];
        $sql = "select * from user_info where email = '$email' ";
        $res = mysqli_query($this->link, $sql);
        if (mysqli_num_rows($res) > 0) {
            return $res;
        } else {
            return false;
        }
        # code...
    }
    public function insertProfileInfo()
    {
        if (isset($_POST['upload'])) {
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $city = $_POST['city'];
            $country = $_POST['country'];
            $img = time() . '_' . $_FILES['image']['name'];
            $target = 'user_img/' . $img;

            if ($_FILES['image']['name'] == '') {
                $sql = "UPDATE `user_info` SET `phone`= '$phone',`country`='$country',`city`='$city', `updated` = CURRENT_TIMESTAMP WHERE email = '$email'";
            } else {
                $sql = "UPDATE `user_info` SET `phone`= '$phone',`country`='$country',`city`='$city', `image` = '$img', `updated` = CURRENT_TIMESTAMP WHERE email = '$email'";
            }


            $res = mysqli_query($this->link, $sql);
            if ($res) {
                move_uploaded_file($_FILES['image']['tmp_name'], $target);
                header('location:profile.php');
                return $res;
            } else {
                echo "Not added";
                return false;
            }
        }
        # code...
    }
}
$obj = new profile;
$objShow = $obj->showProfile();
$objShowInfo = $obj->showProfileInfo();
$objInsertInfo = $obj->insertProfileInfo();
$row = mysqli_fetch_assoc($objShow);
$_SESSION['email'] = $row['email'];
$rowInfo = mysqli_fetch_assoc($objShowInfo);


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
                    <a href="profile.php" class="pt-5 mt-5 font-weight-normal text-dark font-weight-bold  d-block"
                        style="text-decoration: none;">Profile</a>

                    <hr>


                    <a href="notification.php" class=" font-weight-normal text-dark  d-block"
                        style="text-decoration: none;">Order History</a>

                    <hr>
                    <a href="resetpass.php" class=" font-weight-normal text-dark  d-block"
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
                        <div id="output"></div>

                        <h4 class="font-weight-bold" style="color: #481639">Account Details</h4>
                        <form action="" id="myForm" enctype="multipart/form-data">
                            <div class="row mt-4">
                                <div class="col-md-7">
                                    <label for="fullname" class="font-weight-bold">Full Name</label>
                                    <input type="text" id="fullname" name="fullname"
                                        value="<?php echo $row['fname']; ?> <?php echo $row['lname']; ?>"
                                        class="form-control border-0 bg-light" readonly>
                                    <label for="email" class="font-weight-bold mt-4">Email</label>
                                    <input type="email" id="email" value="<?php echo $row['email']; ?>" name="email"
                                        class="form-control border-0 bg-light" readonly>
                                    <label for="phone" class="font-weight-bold mt-4">Phone Number</label>
                                    <input type="text" id="phone" value="<?php echo $rowInfo['phone']; ?>" name="phone"
                                        class="form-control border-0 bg-light">

                                </div>
                                <div class="col-md-5 text-center">

                                    <img class="profileImage" onclick="triggerClick()" id="profileDisplay"
                                        src="user_img/<?php echo $rowInfo['image']; ?>" alt="">
                                    <input type="file" accept="image/*" name="image" id="profileImage"
                                        onchange="displayImage(this)" style="display: none;">
                                    <p class="lead">Tap to upload image</p>
                                </div>

                                <div class="col-md-12">
                                    <label for="country" class="font-weight-bold mt-4">Country</label>
                                    <input type="text" id="country" value="<?php echo $rowInfo['country']; ?>"
                                        name="country" class="form-control border-0 bg-light">
                                </div>
                                <!-- <div class="col-md-6">
                                    <label for="state" class="font-weight-bold mt-4">State</label>
                                    <input type="text" id="state" value="<?php echo $rowInfo['state']; ?>" name="state"
                                        class="form-control border-0 bg-light">
                                </div> -->
                                <div class="col-md-6">
                                    <label for="city" class="font-weight-bold mt-4">City</label>
                                    <input type="text" id="city" value="<?php echo $rowInfo['city']; ?>" name="city"
                                        class="form-control border-0 bg-light">
                                </div>
                            </div>
                            <input class="btn font-weight-bold log_btn btn-lg mt-5" type="submit" value="Confirm">

                        </form>
                    </div>

                </div>
            </div>
        </div>
        <div id="goTop"></div>

    </section>

    <?php include('layout/footer.php'); ?>


    <?php include('layout/script.php') ?>
    <script>
    $(document).ready(function() {
        $('#myForm').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                type: "POST",
                url: "update.php",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $('#output').fadeIn().html(response);
                    setTimeout(() => {
                        $('#output').fadeOut('slow');
                    }, 2000);
                }
            });

        });
    })
    </script>
</body>

</html>