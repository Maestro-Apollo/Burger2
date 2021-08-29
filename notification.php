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
            $state = $_POST['state'];
            $country = $_POST['country'];
            $img = time() . '_' . $_FILES['image']['name'];
            $target = 'user_img/' . $img;

            if ($_FILES['image']['name'] == '') {
                $sql = "UPDATE `user_info` SET `phone`= '$phone',`country`='$country',`state`='$state',`city`='$city', `updated` = CURRENT_TIMESTAMP WHERE email = '$email'";
            } else {
                $sql = "UPDATE `user_info` SET `phone`= '$phone',`country`='$country',`state`='$state',`city`='$city', `image` = '$img', `updated` = CURRENT_TIMESTAMP WHERE email = '$email'";
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
    public function checkoutFunction()
    {
        $email = $_SESSION['email'];
        $sql = "SELECT sum(cart_tbl.cart_price) as price, sum(cart_tbl.cart_item_quantity) as qty
        FROM cart_tbl
        INNER JOIN food_tbl
         ON cart_tbl.food_item = food_tbl.food_id where cart_tbl.cart_item_user = '$email'";
        $res = mysqli_query($this->link, $sql);
        if ($res) {
            return $res;
        } else {
            return false;
        }
        # code...
    }
    public function confirmFunction()
    {
        $email = $_SESSION['email'];
        $sql = "select * from reservation_tbl where email = '$email' ";
        $res = mysqli_query($this->link, $sql);
        if (mysqli_num_rows($res) > 0) {
            return $res;
        } else {
            return false;
        }
        # code...
    }
}
$obj = new profile;
$objShow = $obj->showProfile();
$objShowInfo = $obj->showProfileInfo();
$objInsertInfo = $obj->insertProfileInfo();
$objCheck = $obj->checkoutFunction();
$objConfirm = $obj->confirmFunction();
$rowCheck = mysqli_fetch_assoc($objCheck);
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
                    <a href="profile.php" class="pt-5 mt-5 font-weight-normal text-dark   d-block"
                        style="text-decoration: none;">Profile</a>

                    <hr>
                    <a href="notification.php" class=" font-weight-normal text-dark font-weight-bold d-block"
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
                        <form action="" method="post">

                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">Email</th>
                                        <th scope="col">Delivery Time</th>
                                        <th scope="col">Total Quantity</th>
                                        <th scope="col">Total Price</th>
                                        <th scope="col">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($objConfirm) { ?>
                                    <?php while ($rowCheck = mysqli_fetch_assoc($objConfirm)) { ?>
                                    <tr>
                                        <th scope="row"><?php echo $_SESSION['email']; ?></th>
                                        <input type="hidden" name="email" value="<?php echo $_SESSION['email']; ?>">
                                        <td><?php echo $rowCheck['time']; ?>min</td>
                                        <td><?php echo $rowCheck['qty']; ?></td>
                                        <input type="hidden" name="qty" value="<?php echo $rowCheck['qty']; ?>">
                                        <td>£<?php echo $rowCheck['price']; ?></td>
                                        <td><?php echo $rowCheck['created']; ?></td>
                                        <input type="hidden" name="price" value="<?php echo $rowCheck['price']; ?>">

                                    </tr>
                                    <?php } ?>
                                    <?php } else { ?>
                                    <p>No Order History</p>
                                    <?php } ?>


                                </tbody>
                            </table>



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