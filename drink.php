<?php
//Same as burger.php
session_start();
error_reporting(0);

include('class/database.php');
class profile extends database
{
    protected $link;

    public function foodFunction()
    {
        if (isset($_POST['search'])) {
            $product = trim($_POST['product']);
            $sql = "SELECT * FROM `food_tbl` WHERE category = 'drink' AND food_name like '$product%' ";
        } else {
            $sql = "SELECT * FROM `food_tbl` WHERE category = 'drink'";
        }
        $res = mysqli_query($this->link, $sql);
        if (mysqli_num_rows($res) > 0) {
            return $res;
        } else {
            return false;
        }

        # code...
    }
    public function checkFunction($value)
    {
        if (isset($_SESSION['email'])) {
            $val = $value;
            $email = $_SESSION['email'];
            $sql = "SELECT *
        FROM food_tbl
        INNER JOIN cart_tbl
         ON food_tbl.food_id = cart_tbl.food_item where cart_tbl.cart_item_user =  '$email' AND cart_tbl.food_item = '$val' ";
            $res = mysqli_query($this->link, $sql);
            if (mysqli_num_rows($res) > 0) {
                return $res;
            } else {
                return false;
            }
        }

        # code...
    }
    public function cartFunction()
    {
        if (isset($_POST['submit'])) {
            $user = $_SESSION['email'];
            $id = $_POST['id'];
            $price = $_POST['price'];
            $quantity = 1;
            $sql = "INSERT INTO `cart_tbl` (`cart_id`, `cart_item_quantity`, `cart_price`, `cart_item_user`, `food_item`, `created`) VALUES (NULL, '$quantity', '$price', '$user', '$id', CURRENT_TIMESTAMP)";
            $res = mysqli_query($this->link, $sql);
            if ($res) {
                header('location:drink.php');

                // echo "Added";
            } else {
                echo "Not Added";
            }
        }

        # code...
    }
}
$obj = new profile;
$objBurger = $obj->foodFunction();
$objCart = $obj->cartFunction();


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amazing Burgers</title>
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

    .nav-pills .nav-link.active,
    .nav-pills .show>.nav-link {
        background-color: #00735C !important;
    }

    .nav-pills .nav-link {
        border-radius: .25rem;
        color: #481639;
    }
    </style>

</head>

<body class="bg-light">
    <?php include('layout/navbar.php'); ?>


    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-2">
                    <h3 class="font-weight-bold" style="color: #481639">Drinks</h3>

                    <div class="nav mt-5 flex-column nav-pills" id="v-pills-tab" role="tablist"
                        aria-orientation="vertical">
                        <a class="nav-link active font-weight-bold" id="v-pills-home-tab" data-toggle="pill"
                            href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">Normal</a>
                        <a class="nav-link font-weight-bold" id="v-pills-profile-tab" data-toggle="pill"
                            href="#v-pills-profile" role="tab" aria-controls="v-pills-profile"
                            aria-selected="false">Sugar Free</a>


                    </div>
                </div>
                <div class="col-md-10">


                    <div class="account bg-white mt-5 p-5 rounded">


                        <div class="container">

                            <!-- <h4 class="font-weight-bold" style="color: #481639">Burgers</h4> -->




                            <form action="" method="post">
                                <a href="drink.php" class="mr-3"><i class="fas fa-sync-alt"></i>
                                </a>

                                <input class="form-control mb-4 d-inline w-25 mr-sm-2" type="search" name="product"
                                    placeholder="Search" aria-label="Search">
                                <button class="btn btn-outline-success " name="search" style="margin-bottom: 7px"
                                    type="submit">Search</button>
                            </form>


                            <div class="tab-content" id="v-pills-tabContent">
                                <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel"
                                    aria-labelledby="v-pills-home-tab">
                                    <div class="row">
                                        <?php if ($objBurger) { ?>
                                        <?php while ($row = mysqli_fetch_assoc($objBurger)) { ?>

                                        <?php if (strcmp($row['sub_category'], 'normal') == 0) { ?>
                                        <div class="col-md-5  shadow p-5 mb-5">
                                            <img src="images/<?php echo $row['image']; ?>" class="img-fluid" alt="">
                                            <input type="hidden" name="sub_cat"
                                                value="<?php echo $row['sub_category']; ?>">


                                            <h4 class="font-weight-bold mt-4" style="color: #481639">
                                                <?php echo $row['food_name']; ?></h4>
                                            <h6 class="font-weight-bold mt-1" style="color: #481639">Price:
                                                £<?php echo $row['price']; ?></h6>
                                            <p><?php echo $row['details']; ?></p>
                                            <form action="" id="myForm">
                                                <input type="hidden" name="id" value="<?php echo $row['food_id']; ?>">
                                                <input type="hidden" name="price" value="<?php echo $row['price']; ?>">
                                                <?php if ($obj->checkFunction($row['food_id'])) { ?>
                                                <button class="btn btn-danger font-weight-bold" disabled>Added to
                                                    basket</button>
                                                <?php } else { ?>
                                                <?php if (isset($_SESSION['email'])) { ?>
                                                <input type="submit" class="log_btn btn font-weight-bold"
                                                    value="Add to Basket" name="submit">
                                                <?php } else { ?>
                                                <a href="signInUp.php" class=" btn log_btn font-weight-bold">Add to
                                                    Basket</a>
                                                <?php } ?>

                                                <?php } ?>

                                            </form>

                                        </div>
                                        <div class="col-md-1"></div>
                                        <?php } ?>

                                        <?php } ?>
                                        <?php } ?>


                                    </div>
                                </div>
                                <div class="tab-pane fade" id="v-pills-profile" role="tabpanel"
                                    aria-labelledby="v-pills-profile-tab">
                                    <div class="row">
                                        <?php mysqli_data_seek($objBurger, 0) ?>
                                        <?php if ($objBurger) { ?>
                                        <?php while ($row = mysqli_fetch_assoc($objBurger)) { ?>

                                        <?php if (strcmp($row['sub_category'], 'no-sugar') == 0) { ?>
                                        <div class="col-md-5  shadow p-5 mb-5">
                                            <img src="images/<?php echo $row['image']; ?>" class="img-fluid" alt="">
                                            <input type="hidden" name="sub_cat"
                                                value="<?php echo $row['sub_category']; ?>">


                                            <h4 class="font-weight-bold mt-4" style="color: #481639">
                                                <?php echo $row['food_name']; ?></h4>
                                            <h6 class="font-weight-bold mt-1" style="color: #481639">Price:
                                                £<?php echo $row['price']; ?></h6>
                                            <p><?php echo $row['details']; ?></p>
                                            <form action="" id="myForm2">
                                                <input type="hidden" name="id" value="<?php echo $row['food_id']; ?>">
                                                <input type="hidden" name="price" value="<?php echo $row['price']; ?>">
                                                <?php if ($obj->checkFunction($row['food_id'])) { ?>
                                                <button class="btn btn-danger font-weight-bold" disabled>Added to
                                                    basket</button>
                                                <?php } else { ?>
                                                <?php if (isset($_SESSION['email'])) { ?>
                                                <input type="submit" class="log_btn btn font-weight-bold"
                                                    value="Add to Basket" name="submit">
                                                <?php } else { ?>
                                                <a href="signInUp.php" class=" btn log_btn font-weight-bold">Add to
                                                    Basket</a>
                                                <?php } ?>

                                                <?php } ?>

                                            </form>

                                        </div>
                                        <div class="col-md-1"></div>
                                        <?php }  ?>

                                        <?php } ?>
                                        <?php } ?>


                                    </div>
                                </div>

                            </div>





                        </div>





                    </div>

                </div>
            </div>
        </div>
        <div id="goTop"></div>

    </section>

    <?php include('layout/footer.php'); ?>


    <?php include('layout/script.php') ?>
    <script>
    new WOW().init();
    </script>
    <script>
    $(document).ready(function() {
        $('a[data-toggle="pill"]').on('show.bs.tab', function(e) {
            localStorage.setItem('activeTab', $(e.target).attr('href'));
        });
        var activeTab = localStorage.getItem('activeTab');
        if (activeTab) {
            $('#v-pills-tab a[href="' + activeTab + '"]').tab('show');
        }
    });
    </script>
    <script>
    $(document).ready(function() {

        $('#myForm,#myForm2,#myForm3').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $(this).find('input[type="submit"]').prop("disabled", true);
            $(this).find('input[type="submit"]').toggleClass('btn-danger');
            $(this).find('input[type="submit"]').val('Added to Basket');
            // $("input[type = 'submit']").prop('disabled', true);
            // $('.dis').prop("disabled", true);

            $.ajax({
                type: "POST",
                url: "burgerAjax.php",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $('.output').fadeIn().html(response);
                    setTimeout(() => {
                        $('.output').fadeOut('slow');
                    }, 2000);

                }
            });
        });
    })
    </script>
</body>

</html>