<?php
session_start();
if (isset($_SESSION['email'])) { //This if else will help to prevent any not registered user to see the profile page
} else {
    header('location:signInUp.php');
}
include('class/database.php');
class profile extends database
{
    protected $link;

    public function checkoutFunction()
    {
        $email = $_SESSION['email'];
        //This sql query gives the sum of total price, quantity and time that user confirmed
        $sql = "SELECT sum(cart_tbl.cart_price) as price, sum(cart_tbl.cart_item_quantity) as qty, sum(food_tbl.time) as total_time
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
    public function customFunction()
    {
        $email = $_SESSION['email'];
        //This sql query gives the sum of total price, quantity and time that user confirmed
        $sql = "SELECT SUM(total) as total, SUM(cus_con_qty) as qty, duration as duration from custom_confirm where email = '$email' ";
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
        if (isset($_POST['confirm'])) {
            $email = $_POST['email'];
            $qty = $_POST['qty'];
            $price = $_POST['price'];

            $time = $_POST['time'];
            $street = $_POST['street'];
            $post_code = $_POST['pcode'];
            $house = $_POST['house'];

            //Insert data inside the reservation_tbl
            $sql = "INSERT INTO `reservation_tbl` (`reserve_id`, `email`, `qty`, `price`, `time`, `street`, `house`, `post_code`, `created`) VALUES (NULL, '$email', '$qty', '$price', '$time', '$street', '$house', '$post_code', CURRENT_TIMESTAMP)";
            $res = mysqli_query($this->link, $sql);
            if ($res) {
                //Delete query will delete the data from cart_tbl
                $sql2 =  "DELETE FROM `cart_tbl` WHERE `cart_tbl`.`cart_item_user` = '$email'";
                $res2 = mysqli_query($this->link, $sql2);
                if ($res2) {
                    $sql2 = "DELETE FROM custom_confirm where email = '$email' ";
                    $res2 = mysqli_query($this->link, $sql2);
                    $sql2 = "DELETE FROM custom_cart where email = '$email' ";
                    $res2 = mysqli_query($this->link, $sql2);
                    header('location:profile.php');
                } else {
                    return false;
                }
            }
        }
        # code...
    }
}
$obj = new profile;

$objCheck = $obj->checkoutFunction();
$objCustom = $obj->customFunction();
$objConfirm = $obj->confirmFunction();
$rowCheck = mysqli_fetch_assoc($objCheck);
$rowCustom = mysqli_fetch_assoc($objCustom);



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


                    <div class="account bg-white mt-5 p-5 rounded">
                        <form action="" method="post" data-parsley-validate>

                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">Type</th>
                                        <th scope="col">Delivery Time</th>
                                        <th scope="col">Total Quantity</th>
                                        <th scope="col">Total Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($objCheck) { ?>
                                    <tr class="bg-light">
                                        <th scope="row">Regular</th>
                                        <!-- <input type="hidden" name="email" value="<?php echo $_SESSION['email']; ?>"> -->
                                        <td>-</td>
                                        <!-- <input type="hidden" name="time" value="<?php echo $rowCheck['total_time']; ?>"> -->
                                        <td><?php echo $rowCheck['qty']; ?></td>
                                        <!-- <input type="hidden" name="qty" value="<?php echo $rowCheck['qty']; ?>"> -->
                                        <td>£<?php echo $rowCheck['price']; ?></td>
                                        <!-- <input type="hidden" name="price" value="<?php echo $rowCheck['price']; ?>"> -->

                                    </tr>
                                    <?php } ?>
                                    <?php if (isset($objCustom)) { ?>
                                    <tr class="bg-warning">
                                        <th scope="row">Custom Burger</th>
                                        <!-- <input type="hidden" name="email" value="<?php echo $_SESSION['email']; ?>"> -->
                                        <td>-</td>
                                        <!-- <input type="hidden" name="time" value="<?php echo $rowCustom['total_time']; ?>"> -->
                                        <td><?php echo $rowCustom['qty']; ?></td>
                                        <!-- <input type="hidden" name="qty" value="<?php echo $rowCustom['qty']; ?>"> -->
                                        <td>£<?php echo $rowCustom['total']; ?></td>
                                        <!-- <input type="hidden" name="price" value="<?php echo $rowCustom['price']; ?>"> -->

                                    </tr>
                                    <?php } ?>

                                    <tr class="bg-dark text-white">
                                        <th scope="row">Total</th>
                                        <input type="hidden" name="email" value="<?php echo $_SESSION['email']; ?>">
                                        <th><?php echo 14 + $rowCheck['qty'] + $rowCustom['qty']; ?>min
                                        </th>
                                        <input type="hidden" name="time"
                                            value="<?php echo 14 + $rowCheck['qty'] + $rowCustom['qty']; ?>">
                                        <th><?php echo $rowCheck['qty'] + $rowCustom['qty']; ?></th>
                                        <input type="hidden" name="qty"
                                            value="<?php echo $rowCheck['qty'] + $rowCustom['qty']; ?>">
                                        <th>£<?php echo number_format((float)$rowCheck['price'] + $rowCustom['total'], 2, '.', ''); ?>
                                        </th>
                                        <input type="hidden" name="price"
                                            value="<?php echo $rowCheck['price'] + $rowCustom['total']; ?>">

                                    </tr>

                                </tbody>
                            </table>
                            <h5 class="mt-4">Enter your details</h5>

                            <div class="row">
                                <div class="col-md-4">
                                    <label for="street">Street Address</label>
                                    <input type="text" id="street" name="street" class="form-control border-0 bg-light"
                                        required>
                                </div>
                                <div class="col-md-4">
                                    <label for="house">House Number</label>
                                    <input type="text" data-parsley-type="digits" id="house" name="house"
                                        class="form-control border-0 bg-light" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="pcode">Post Code</label>
                                    <input type="text" id="pcode" name="pcode" class="form-control border-0 bg-light"
                                        required>
                                </div>
                            </div>
                            <input class="btn font-weight-bold log_btn btn-lg mt-4" name="confirm" type="submit"
                                value="Confirm">
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