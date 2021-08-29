<?php
session_start();
// error_reporting(0);

include('class/database.php');
class profile extends database
{
    protected $link;
    // To show user info
    public function showProfile()
    {
        if (isset($_SESSION['email'])) {
            $email = $_SESSION['email'];
            $sql = "select * from user_tbl where email = '$email' ";
            $res = mysqli_query($this->link, $sql);
            if (mysqli_num_rows($res) > 0) {
                return $res;
            } else {
                return false;
            }
        }
        # code...
    }


    // To show user info in details

    public function showProfileInfo()
    {
        if (isset($_SESSION['email'])) {
            $email = $_SESSION['email'];
            $sql = "select * from user_info where email = '$email' ";
            $res = mysqli_query($this->link, $sql);
            if (mysqli_num_rows($res) > 0) {
                return $res;
            } else {
                return false;
            }
        }
        # code...
    }


    // Create the burger
    public function customFunction()
    {
        $sql = "SELECT * from custom_tbl order by FIELD(custom_position, 'top-1','top-2','middle', 'bottom-2','bottom-1','extra')";
        $res = mysqli_query($this->link, $sql);
        if (mysqli_num_rows($res) > 0) {
            return $res;
        } else {
            return false;
        }
        # code...
    }
    public function customInsert()
    {
        //This will update the burger feature
        if (isset($_POST['upload'])) {
            if (isset($_SESSION['email'])) {
                $time = time();




                for ($i = 1; $i < 18; $i++) {
                    $customName = $_POST['Custom' . $i];
                    $email = $_SESSION['email'];
                    $custom_item = $i;

                    if (($_POST['Custom4'] != 0 || $_POST['Custom10'] != 0) && ($_POST['Custom5'] != 0 || $_POST['Custom11'] != 0) && ($_POST['Custom2'] != 0 || $_POST['Custom3'] != 0 || $_POST['Custom13'] != 0) && ($_POST['Custom1'] != 0 || $_POST['Custom6'] != 0 || $_POST['Custom8'] != 0) &&  $_POST['Custom9'] != 0) {

                        $sql = "SELECT * from custom_cart where email = '$email' AND  custom_cart_type = $i AND confirm = 0";
                        $res = mysqli_query($this->link, $sql);
                        if (mysqli_num_rows($res) > 0) {
                            $sql = "UPDATE `custom_cart` SET `custom_cart_qty`= $customName WHERE custom_cart_type = $i AND email = '$email' AND confirm = 0 ";
                            $res = mysqli_query($this->link, $sql);
                        } else {
                            $sql = "INSERT INTO `custom_cart` (`custom_cart_id`, `custom_cart_type`, `custom_cart_qty`, `email`,`confirm`,`time`) VALUES (NULL, '$custom_item', '$customName', '$email',0,'$time')";
                            $res = mysqli_query($this->link, $sql);
                        }
                    } else {
                        $msg = '<div class="alert pl-5  alert-warning alert-dismissible fade show">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>Must Need Items<ul><li>1 Top Bun & 1 Bottom Bun</li><li>1 Cheese</li><li>1 Patty</li><li>1 Lettuce</li></ul></strong>
                    </div>';
                        return $msg;
                    }
                }
            } else {
                header('location:signInUp.php');
            }
        }
        # code...
    }
    public function createBurger()
    {
        //This function will create burger
        if (isset($_SESSION['email'])) {
            $email = $_SESSION['email'];
            $sql = "SELECT * from custom_cart INNER join custom_tbl on custom_cart.custom_cart_type = custom_tbl.custom_id WHERE email = '$email' AND custom_cart.custom_cart_qty <> 0 AND custom_cart.confirm = 0 order by FIELD(custom_tbl.custom_position, 'top-1','top-2','middle', 'bottom-2','bottom-1')";
            $res = mysqli_query($this->link, $sql);
            if (mysqli_num_rows($res) > 0) {
                return $res;
            } else {
                return false;
            }
        }
        # code...
    }
    public function showInputFunction($value)
    {
        //Show all the qty and price of the burger
        if (isset($_SESSION['email'])) {
            $val = $value;
            $email = $_SESSION['email'];
            $sql = "SELECT custom_cart.custom_cart_qty from custom_cart INNER join custom_tbl on custom_cart.custom_cart_type = custom_tbl.custom_id WHERE email = '$email' AND custom_cart_type = $val AND custom_cart.confirm = 0 ";
            $res = mysqli_query($this->link, $sql);
            if ($res) {
                $row = mysqli_fetch_assoc($res);
                return $row['custom_cart_qty'];
            } else {
                return 0;
            }
        }
        # code...
    }
    public function confirmCustom()
    {
        //This will redo the feature
        if (isset($_POST['redo'])) {
            $email = $_SESSION['email'];
            $total = $_POST['price'];
            $time = $_POST['time'];
            $sql = "DELETE from custom_cart where email = '$email' AND `time` = '$time'  ";
            $res = mysqli_query($this->link, $sql);
            if ($res) {
                header('location:create.php');
            }
        }
        //This will confirm the burger
        if (isset($_POST['confirm'])) {
            $email = $_SESSION['email'];
            $total = $_POST['price'];
            $time = $_POST['time'];
            if ($_POST['name'] == '') {
                $name = "Custom Burger";
            } else {
                $name = $_POST['name'];
            }
            $sql = "UPDATE custom_cart set confirm = 1 where email = '$email' AND `time` = $time ";
            $res = mysqli_query($this->link, $sql);
            if ($res) {
                $sql = "INSERT INTO `custom_confirm` (`cus_con_id`, `cus_con_qty`, `price`, `total`, `email`,`name`,`duration`, `time`) VALUES (NULL, 1, $total, $total ,  '$email','$name','10', $time)";
                mysqli_query($this->link, $sql);
                header('location:cart.php');
            }

            // $sql = ""


        }
        # code...
    }
    // public function showCustom()
    // {
    //     $sql = ""
    //     # code...
    // }
}
$obj = new profile;
$objShow = $obj->showProfile();
$objShowInfo = $obj->showProfileInfo();
$objCustom = $obj->customFunction();
$objInsert = $obj->customInsert();
$objCreate = $obj->createBurger();
$objConfirm = $obj->confirmCustom();
// echo $obj->showInputFunction(2);
if (isset($_SESSION['email'])) {
    $row = mysqli_fetch_assoc($objShow);
    $_SESSION['email'] = $row['email'];
    $rowInfo = mysqli_fetch_assoc($objShowInfo);
}

$total = 0;
$time = 0;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php include('layout/style.php'); ?>
    <link
        href="https://fonts.googleapis.com/css2?family=Abril+Fatface&family=Alfa+Slab+One&family=Anton&family=Bungee&family=Fredoka+One&family=Limelight&display=swap"
        rel="stylesheet">
    <style>
    .profileImage {
        height: 200px;
        width: 200px;
        object-fit: cover;
        border-radius: 50%;
        margin: 10px auto;
        cursor: pointer;

    }

    .nav-pills .nav-link.active,
    .nav-pills .show>.nav-link {
        background-color: #00735C !important;
    }

    .nav-pills .nav-link {
        border-radius: .25rem;
        color: #481639;
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

                <div class="col-md-12">
                    <?php if (isset($_SESSION['email'])) { ?>
                    <h3 class="float-right d-block font-weight-bold" style="color: #481639"><span
                            class="text-secondary font-weight-light">Welcome |</span>
                        <?php echo $row['fname'] ?>
                        <?php echo $row['lname']; ?></h3>
                    <?php } ?>
                    <form action="" method="post">
                        <div class="account bg-white mt-5 p-5 rounded">
                            <?php echo $objInsert; ?>
                            <?php if ($objCreate) { ?>
                            <div class="row">
                                <div class="col-md-3"></div>
                                <div class="col-md-3 wow pulse" data-wow-iteration="infinite">

                                    <?php while ($row = mysqli_fetch_assoc($objCreate)) { ?>

                                    <?php for ($i = 0; $i < $row['custom_cart_qty']; $i++) { ?>

                                    <img class="d-block" src="create/<?php echo $row['custom_image']; ?>" alt="">
                                    <?php } ?>
                                    <?php $time = $row['time']; ?>
                                    <?php $total += $row['custom_price'] * $row['custom_cart_qty']; ?>
                                    <?php } ?>


                                </div>
                                <div class="col-md-6 p-5 mt-2 text-center">
                                    <h2 class=" wow tada" style="font-family: 'Alfa Slab One', cursive;">
                                        Your
                                        Burger is Created!!!</h2>
                                    <h3 class="wow zoomIn" style="font-family: 'Alfa Slab One', cursive;">Price:
                                        £<?php echo number_format((float)$total, 2, '.', ''); ?></h3>
                                    <form action="" method="post">
                                        <input type="text" id="" name="name" placeholder="Name Your Burger (Optional)"
                                            class="form-control border-0 bg-light">
                                        <input type="hidden" name="price" value="<?php echo $total; ?>">
                                        <input type="hidden" name="time" value="<?php echo $time; ?>">
                                        <button class="btn font-weight-bold log_btn btn-lg mt-5" type="submit"
                                            name="confirm">Add to Basket</button>
                                        <button class="btn font-weight-bold log_btn btn-lg mt-5" type="submit"
                                            name="redo">Redo</button>
                                    </form>
                                </div>
                                <!-- <div class="col-md-3"></div> -->
                            </div>
                            <?php } ?>


                            <ul class="nav mt-5 nav-pills pill_color mb-3" id="pills-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link font-weight-bold active" id="pills-home-tab" data-toggle="pill"
                                        href="#bun" role="tab" aria-controls="pills-home" aria-selected="true">Bun</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link font-weight-bold" id="pills-profile-tab" data-toggle="pill"
                                        href="#meat" role="tab" aria-controls="pills-profile"
                                        aria-selected="false">Meat</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link font-weight-bold" id="pills-contact-tab" data-toggle="pill"
                                        href="#cheese" role="tab" aria-controls="pills-contact"
                                        aria-selected="false">Cheese</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link font-weight-bold" id="pills-contact-tab" data-toggle="pill"
                                        href="#topping" role="tab" aria-controls="pills-contact"
                                        aria-selected="false">Topping</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link font-weight-bold" id="pills-contact-tab" data-toggle="pill"
                                        href="#sauce" role="tab" aria-controls="pills-contact"
                                        aria-selected="false">Sauce</a>
                                </li>
                            </ul>


                            <hr>





                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="bun" role="tabpanel"
                                    aria-labelledby="pills-home-tab">
                                    <?php if ($objCustom) { ?>
                                    <?php while ($row = mysqli_fetch_assoc($objCustom)) { ?>
                                    <?php if (strcmp($row['custom_category'], 'bun') == 0) { ?>
                                    <div class="row mt-4">
                                        <div class="col-md-6">
                                            <img class="w-50" src="create/<?php echo $row['custom_image']; ?>" alt="">

                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <p class="font-weight-bold mb-0"><?php echo $row['custom_type']; ?>
                                                    </p>
                                                    <small
                                                        class="font-weight-bold">£<?php echo $row['custom_price']; ?></small>
                                                </div>
                                                <div class="col-md-6">

                                                    <label for="" class="font-weight-bold">Quantity</label>
                                                    <input min="0" name="Custom<?php echo $row['custom_id']; ?>"
                                                        type="number"
                                                        value="<?php echo $obj->showInputFunction($row['custom_id']); ?>"
                                                        class="text-white form-control font-weight-bold border-0 bg-secondary">

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <hr>
                                    <?php } ?>
                                    <?php } ?>

                                    <?php } ?>


                                </div>
                                <div class="tab-pane fade" id="meat" role="tabpanel" aria-labelledby="pills-home-tab">
                                    <?php mysqli_data_seek($objCustom, 0) ?>
                                    <?php if ($objCustom) { ?>
                                    <?php while ($row = mysqli_fetch_assoc($objCustom)) { ?>
                                    <?php if (strcmp($row['custom_category'], 'meat') == 0) { ?>
                                    <div class="row mt-4">
                                        <div class="col-md-6">
                                            <img class="w-50" src="create/<?php echo $row['custom_image']; ?>" alt="">

                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <p class="font-weight-bold mb-0"><?php echo $row['custom_type']; ?>
                                                    </p>
                                                    <small
                                                        class="font-weight-bold">£<?php echo $row['custom_price']; ?></small>
                                                </div>
                                                <div class="col-md-6">

                                                    <label for="" class="font-weight-bold">Quantity</label>
                                                    <input min="0" name="Custom<?php echo $row['custom_id']; ?>"
                                                        type="number"
                                                        value="<?php echo $obj->showInputFunction($row['custom_id']); ?>"
                                                        class="text-white form-control font-weight-bold border-0 bg-secondary">

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <hr>
                                    <?php } ?>
                                    <?php } ?>

                                    <?php } ?>

                                </div>


                                <div class="tab-pane fade" id="cheese" role="tabpanel"
                                    aria-labelledby="pills-contact-tab">
                                    <?php mysqli_data_seek($objCustom, 0) ?>
                                    <?php if ($objCustom) { ?>
                                    <?php while ($row = mysqli_fetch_assoc($objCustom)) { ?>
                                    <?php if (strcmp($row['custom_category'], 'cheese') == 0) { ?>
                                    <div class="row mt-4">
                                        <div class="col-md-6">
                                            <img class="w-50" src="create/<?php echo $row['custom_image']; ?>" alt="">

                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <p class="font-weight-bold mb-0"><?php echo $row['custom_type']; ?>
                                                    </p>
                                                    <small
                                                        class="font-weight-bold">£<?php echo $row['custom_price']; ?></small>
                                                </div>
                                                <div class="col-md-6">

                                                    <label for="" class="font-weight-bold">Quantity</label>
                                                    <input min="0" name="Custom<?php echo $row['custom_id']; ?>"
                                                        type="number"
                                                        value="<?php echo $obj->showInputFunction($row['custom_id']); ?>"
                                                        class="text-white form-control font-weight-bold border-0 bg-secondary">

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <hr>
                                    <?php } ?>
                                    <?php } ?>

                                    <?php } ?>


                                </div>
                                <div class="tab-pane fade" id="topping" role="tabpanel"
                                    aria-labelledby="pills-contact-tab">
                                    <?php mysqli_data_seek($objCustom, 0) ?>
                                    <?php if ($objCustom) { ?>
                                    <?php while ($row = mysqli_fetch_assoc($objCustom)) { ?>
                                    <?php if (strcmp($row['custom_category'], 'topping') == 0) { ?>
                                    <div class="row mt-4">
                                        <div class="col-md-6">
                                            <img class="w-50" src="create/<?php echo $row['custom_image']; ?>" alt="">

                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <p class="font-weight-bold mb-0"><?php echo $row['custom_type']; ?>
                                                    </p>
                                                    <small
                                                        class="font-weight-bold">£<?php echo $row['custom_price']; ?></small>
                                                </div>
                                                <div class="col-md-6">

                                                    <label for="" class="font-weight-bold">Quantity</label>
                                                    <input min="0" name="Custom<?php echo $row['custom_id']; ?>"
                                                        type="number"
                                                        value="<?php echo $obj->showInputFunction($row['custom_id']); ?>"
                                                        class="text-white form-control font-weight-bold border-0 bg-secondary">

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <hr>
                                    <?php } ?>
                                    <?php } ?>

                                    <?php } ?>


                                </div>
                                <div class="tab-pane fade" id="sauce" role="tabpanel"
                                    aria-labelledby="pills-contact-tab">
                                    <?php mysqli_data_seek($objCustom, 0) ?>
                                    <?php if ($objCustom) { ?>
                                    <?php while ($row = mysqli_fetch_assoc($objCustom)) { ?>
                                    <?php if (strcmp($row['custom_category'], 'sauce') == 0) { ?>
                                    <div class="row mt-4">
                                        <div class="col-md-6">
                                            <img class="w-50" src="create/<?php echo $row['custom_image']; ?>" alt="">

                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <p class="font-weight-bold mb-0"><?php echo $row['custom_type']; ?>
                                                    </p>
                                                    <small
                                                        class="font-weight-bold">£<?php echo $row['custom_price']; ?></small>
                                                </div>
                                                <div class="col-md-6">

                                                    <label for="" class="font-weight-bold">Quantity</label>
                                                    <input min="0" name="Custom<?php echo $row['custom_id']; ?>"
                                                        type="number"
                                                        value="<?php echo $obj->showInputFunction($row['custom_id']); ?>"
                                                        class="text-white form-control font-weight-bold border-0 bg-secondary">

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <hr>
                                    <?php } ?>
                                    <?php } ?>

                                    <?php } ?>

                                </div>


                            </div>








                            <button class="btn font-weight-bold log_btn btn-lg mt-5" type="submit" name="upload">Create
                                Burger</button>
                        </div>
                    </form>


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
    <script>
    $(document).ready(function() {
        $('a[data-toggle="pill"]').on('show.bs.tab', function(e) {
            localStorage.setItem('activeTab', $(e.target).attr('href'));
        });
        var activeTab = localStorage.getItem('activeTab');
        if (activeTab) {
            $('#pills-tab a[href="' + activeTab + '"]').tab('show');
        }
    });
    </script>
</body>

</html>