<?php
session_start();
include('class/database.php');
class profile extends database
{
    protected $link;
    public function cartFunction() //To check user already have item inside database
    {
        if (isset($_SESSION['email'])) {
            $email = $_SESSION['email'];
            $sql = "SELECT *
        FROM cart_tbl
        INNER JOIN food_tbl
         ON cart_tbl.food_item = food_tbl.food_id where cart_tbl.cart_item_user = '$email' order by FIELD(category, 'main','side','drink')"; //Join query to find out items inside cart_tbl
            $res = mysqli_query($this->link, $sql);
            if (mysqli_num_rows($res) > 0) {
                return $res;
            } else {
                return false;
            }
        }
    }
    public function updateFunction() //update function to update the item info
    {
        if (isset($_POST['add'])) {
            $id = $_POST['id'];

            $qty = $_POST['quantity'];
            $price = $_POST['price'];
            $total = $qty * $price;
            $sql = "UPDATE cart_tbl SET cart_item_quantity = '$qty', cart_price = '$total' WHERE cart_id = '$id' ";
            $res = mysqli_query($this->link, $sql); //Execute Update query to update the data
            if ($res) {
                header('location:cart.php');
            } else {
                return false;
            }
        }
        if (isset($_POST['add2'])) {
            $id = $_POST['id'];

            $qty = $_POST['quantity'];
            $price = $_POST['price'];
            $total = $qty * $price;
            $sql = "UPDATE custom_confirm SET cus_con_qty = $qty, total = $total where cus_con_id = $id ";
            $res = mysqli_query($this->link, $sql); //Execute Update query to update the data
            if ($res) {
                header('location:cart.php');
            } else {
                return false;
            }
        }
    }
    public function customFunction() //update function to update the item info
    {
        $email = $_SESSION['email'];
        $sql = "SELECT * from custom_confirm INNER JOIN custom_cart ON custom_confirm.time = custom_cart.time where custom_confirm.email = '$email' AND confirm = 1 group by custom_confirm.time DESC";
        $res = mysqli_query($this->link, $sql);
        if (mysqli_num_rows($res) > 0) {
            return $res;
        } else {
            return false;
        }
    }
    public function imageFunction($value) //update function to update the item info
    {
        $val = $value;
        $email = $_SESSION['email'];
        $sql = "SELECT * from custom_cart INNER join custom_tbl on custom_cart.custom_cart_type = custom_tbl.custom_id WHERE email = '$email' AND `time` = $val AND custom_cart.custom_cart_qty <> 0 AND custom_cart.confirm = 1 order by FIELD(custom_tbl.custom_position, 'top-1','top-2','middle', 'bottom-2','bottom-1')";
        $res = mysqli_query($this->link, $sql);
        if (mysqli_num_rows($res) > 0) {
            return $res;
        } else {
            return false;
        }
    }
}
$obj = new profile;
$objCart = $obj->cartFunction();
$objCustom = $obj->customFunction();
$objUpdate = $obj->updateFunction();


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

    img {
        width: 100%;
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

                    <?php if ($objCustom) { ?>
                    <?php while ($row = mysqli_fetch_assoc($objCustom)) { ?>
                    <?php $objImage = $obj->imageFunction($row['time']);
                            // echo var_dump($objImage);
                            ?>
                    <div class="row border-0 shadow mb-5 bg-warning">
                        <div class="col-md-4">
                            <?php while ($row2 = mysqli_fetch_assoc($objImage)) { ?>
                            <?php for ($i = 0; $i < $row2['custom_cart_qty']; $i++) { ?>

                            <img class="d-block w-75" src="create/<?php echo $row2['custom_image']; ?>" alt="">
                            <?php } ?>
                            <?php } ?>

                        </div>
                        <div class="col-md-8 p-5">
                            <form action="" class="" method="post">
                                <h4 class="font-weight-bold" style="color: #481639">
                                    <?php echo $row['name']; ?> (<span
                                        class="text-dark">£<?php echo $row['total']; ?></span>)
                                </h4>
                                <h5 class="font-weight-bold mt-3" style="color: #481639"> Quantity: <input class=" w-25"
                                        name="quantity" value="<?php echo $row['cus_con_qty']; ?>" type="number"
                                        min="1"> </h5>

                                <input type="hidden" name="price" value="<?php echo $row['price']; ?>">
                                <input type="hidden" name="id" value="<?php echo $row['cus_con_id']; ?>">
                                <input type="submit" name="add2" class="btn btn-success" value="Add">
                                <a href="delete.php?time=<?php echo $row['time']; ?>" class="btn btn-danger">Remove</a>

                            </form>

                        </div>

                    </div>
                    <?php } ?>
                    <?php } else { ?>
                    <!-- <h5 class="float-left font-weight-bold" style="color: #481639">No item</h5> <?php } ?> 

                    <!-- <?php if ($objCart) { ?>
                    <a href="checkout.php" class="btn mt-5 font-weight-bold btn-lg log_btn shadow">Checkout</a>
                    <?php } else { ?>

                    <?php } ?> -->


                    <?php if ($objCart) { ?>
                    <?php while ($row = mysqli_fetch_assoc($objCart)) { ?>
                    <div class="row border-0 shadow mb-5">
                        <div class="col-md-4">
                            <img src="images/<?php echo $row['image']; ?>" alt="">
                        </div>
                        <div class="col-md-8 p-5">
                            <form action="" class="" method="post">
                                <h4 class="font-weight-bold" style="color: #481639">
                                    <?php echo $row['food_name']; ?>(<span
                                        class="text-muted">£<?php echo $row['cart_price']; ?></span>)</h4>
                                <h5 class="font-weight-bold mt-3" style="color: #481639"> Quantity: <input class=" w-25"
                                        name="quantity" value="<?php echo $row['cart_item_quantity']; ?>" type="number"
                                        min="1"> </h5>
                                <p class="mt-3"><?php echo $row['details']; ?></p>
                                <input type="hidden" name="price" value="<?php echo $row['price']; ?>">
                                <input type="hidden" name="id" value="<?php echo $row['cart_id']; ?>">
                                <input type="submit" name="add" class="btn btn-success" value="Add">
                                <a href="delete.php?id=<?php echo $row['cart_id']; ?>" class="btn btn-danger">Remove</a>

                            </form>

                        </div>

                    </div>
                    <?php } ?>
                    <?php }  ?>


                    <?php if ($objCart || $objCustom) { ?>
                    <a href="checkout.php" class="btn mt-5 font-weight-bold btn-lg log_btn shadow">Checkout</a>
                    <?php } else { ?>

                    <?php } ?>

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