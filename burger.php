<?php
session_start(); //to access session variables
error_reporting(0);

include('class/database.php'); //import database class
class profile extends database //create profile class
{
    protected $link;
    public function burgerFunction() //find target product in food_tbl
    {
        if (isset($_POST['search'])) { //Clicking search button
            $product = trim($_POST['product']);
            // $sub_cat = $_POST['sub_cat'];
            $sql = "SELECT * FROM `food_tbl` WHERE category = 'main' AND food_name like '$product%' ";
        } else {
            $sql = "SELECT * FROM `food_tbl` WHERE category = 'main'";
        }
        $res = mysqli_query($this->link, $sql); //execute the query using mysqli_query function
        if (mysqli_num_rows($res) > 0) { //when table has at lease one row
            return $res;
        } else {
            return false;
        }

        # code...
    }
    public function checkFunction($value) //To check if the user already add the item in basket
    {
        if (isset($_SESSION['email'])) {
            $val = $value;
            $email = $_SESSION['email'];
            $sql = "SELECT *
        FROM food_tbl
        INNER JOIN cart_tbl
         ON food_tbl.food_id = cart_tbl.food_item where cart_tbl.cart_item_user =  '$email' AND cart_tbl.food_item = '$val' ";
            $res = mysqli_query($this->link, $sql); //Join query to check if the user already add the product in the basket
            if (mysqli_num_rows($res) > 0) {
                return $res;
            } else {
                return false;
            }
        }

        # code...
    }
    public function cartFunction() //Add inside database function
    {
        if (isset($_POST['submit'])) {
            $user = $_SESSION['email'];
            $id = $_POST['id'];
            $price = $_POST['price'];
            $quantity = 1;
            $sql = "INSERT INTO `cart_tbl` (`cart_id`, `cart_item_quantity`, `cart_price`, `cart_item_user`, `food_item`, `created`) VALUES (NULL, '$quantity', '$price', '$user', '$id', CURRENT_TIMESTAMP)"; //Insert the item inside database
            $res = mysqli_query($this->link, $sql);
            if ($res) {
                header('location:burger.php');
                // echo "Added";
            } else {
                echo "Not Added";
            }
        }

        # code...
    }
}
$obj = new profile; //Object is created
$objBurger = $obj->burgerFunction(); //Call the function which is belong that class
// echo var_dump($objBurger);
// echo '<br>';
// echo var_dump($objBurger);

$objCart = $obj->cartFunction();


//burger.php, drink.php and side.php they all have same functionality. Only the category is changed

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

    .pill_color .active a,
    .pill_color .active a:hover {
        background-color: #00735C;
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

                    <h3 class="font-weight-bold" style="color: #481639">Burgers</h3>
                    <div class="nav mt-5 flex-column nav-pills" id="v-pills-tab" role="tablist"
                        aria-orientation="vertical">
                        <a class="nav-link active font-weight-bold" id="v-pills-home-tab" data-toggle="pill"
                            href="#v-pills-home" role="tab" aria-controls="v-pills-home"
                            aria-selected="true">Chicken</a>
                        <a class="nav-link font-weight-bold" id="v-pills-profile-tab" data-toggle="pill"
                            href="#v-pills-profile" role="tab" aria-controls="v-pills-profile"
                            aria-selected="false">Beef</a>
                        <a class="nav-link font-weight-bold" id="v-pills-messages-tab" data-toggle="pill"
                            href="#v-pills-messages" role="tab" aria-controls="v-pills-messages"
                            aria-selected="false">Vegan</a>

                    </div>


                    <!-- <a href="profile.php" class="pt-5 mt-4 font-weight-normal text-dark   d-block"
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
                        style="text-decoration: none;">Logout</a> -->
                </div>
                <div class="col-md-10">


                    <div class="account bg-white mt-5 p-5 rounded">


                        <div class="container">
                            <!-- <h4 class="font-weight-bold" style="color: #481639">Burgers</h4> -->




                            <form action="" method="post">
                                <a href="burger.php" class="mr-3"><i class="fas fa-sync-alt"></i>
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

                                        <?php if (strcmp($row['sub_category'], 'chicken') == 0) { ?>
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

                                        <?php if (strcmp($row['sub_category'], 'beef') == 0) { ?>
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
                                        <?php } ?>
                                        <?php } ?>
                                        <?php } ?>


                                    </div>
                                </div>
                                <div class="tab-pane fade" id="v-pills-messages" role="tabpanel"
                                    aria-labelledby="v-pills-messages-tab">
                                    <div class="row">
                                        <?php mysqli_data_seek($objBurger, 0) ?>
                                        <?php if ($objBurger) { ?>
                                        <?php while ($row = mysqli_fetch_assoc($objBurger)) { ?>

                                        <?php if (strcmp($row['sub_category'], 'vegan') == 0) { ?>
                                        <div class="col-md-5  shadow p-5 mb-5">
                                            <img src="images/<?php echo $row['image']; ?>" class="img-fluid" alt="">
                                            <input type="hidden" name="sub_cat"
                                                value="<?php echo $row['sub_category']; ?>">


                                            <h4 class="font-weight-bold mt-4" style="color: #481639">
                                                <?php echo $row['food_name']; ?></h4>
                                            <h6 class="font-weight-bold mt-1" style="color: #481639">Price:
                                                £<?php echo $row['price']; ?></h6>
                                            <p><?php echo $row['details']; ?></p>
                                            <form action="" id="myForm3">
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