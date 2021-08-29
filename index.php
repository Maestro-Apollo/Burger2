<?php
session_start(); //to access session variables
include('class/database.php'); //import database class
class profile extends database //create profile class
{
    protected $link;
    public function burgerFunction() //find target product in food_tbl
    {
        if (isset($_POST['search'])) { //Clicking search button
            $product = trim($_POST['product']);
            $sql = "SELECT * FROM `food_tbl` where food_name like '$product%' order by FIELD(category, 'main', 'side', 'drink') ";
        } else {
            $sql = "SELECT * FROM `food_tbl` order by FIELD(category, 'main', 'side', 'drink')";
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
                header('location:index.php');
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
    .big-checkbox {
        width: 20px;
        height: 20px;
    }

    .big-checkbox:checked {
        background-color: #EEA11D !important;
    }

    .checkbox-round {
        width: 1.3em;
        height: 1.3em;
        background-color: white;
        border-radius: 50%;
        vertical-align: middle;
        border: 1px solid grey;
        -webkit-appearance: none;

        cursor: pointer;
    }

    .checkbox-round:checked {
        background-color: #EEA11D;
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

    <?php include('layout/hero_section.php'); ?>


    <div class="bg-white p-5">
        <div class="container">
            <h3 class="font-weight-bold" style="color: #481639">Our Items</h3>



            <form class="form-inline" method="post">
                <label for="search" class="font-weight-bold mr-2">Search Food Name: </label>
                <input class="form-control mr-sm-2" type="text" name="product" id="search" placeholder="Search"
                    aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" name="search" type="submit">Search</button>
                <a href="index.php" class="ml-3"><i class="fas fa-sync-alt"></i>
                </a>

            </form>



            <div class="row">
                <?php if ($objBurger) { ?>
                <?php while ($row = mysqli_fetch_assoc($objBurger)) { ?>
                <div class="col-md-4 wow fadeInUp shadow p-5 mb-5">
                    <img src="images/<?php echo $row['image']; ?>" class="img-fluid" alt="">
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
                        <input type="submit" class="log_btn btn font-weight-bold" value="Add to Basket" name="submit">
                        <?php } else { ?>
                        <a href="signInUp.php" class=" btn log_btn font-weight-bold">Add to
                            Basket</a>
                        <?php } ?>

                        <?php } ?>

                    </form>

                </div>
                <?php } ?>
                <?php } ?>


            </div>







        </div>
    </div>
    <div id="goTop"></div>




    <?php include('layout/footer.php'); ?>


    <?php include('layout/script.php') ?>
    <script>
    //Ajax call to show the food items
    // $(document).ready(function() {
    //     $('#search').keyup(function() {
    //         let search = $(this).val();
    //         if (search != '') {
    //             $.ajax({
    //                 type: "POST",
    //                 url: "show.php",
    //                 data: {
    //                     search: search
    //                 },
    //                 dataType: "text",
    //                 success: function(response) {
    //                     $('#output').fadeIn();
    //                     $('#output').html(response);

    //                 }
    //             });
    //         } else {
    //             output();

    //         }
    //     });
    //     output();

    //     function output() {
    //         $.ajax({
    //             type: "GET",
    //             url: "show.php", //All the data will come from this url
    //             dataType: "text",
    //             success: function(response) {
    //                 $('#output').html(response);
    //             }
    //         });
    //     }

    // })
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
    <script>
    new WOW().init();
    </script>

</body>

</html>