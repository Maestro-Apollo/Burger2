<?php
require_once('../class/database.php');
class show extends database
{
    public function editFunction()
    {
        //This will find the food
        $id = $_GET['id'];
        $sql = "SELECT * from food_tbl where food_id = $id ";
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
        //This function will enter new value inside database
        if (isset($_POST['submit'])) {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $price = $_POST['price'];
            $category = $_POST['category'];
            $details = $_POST['details'];
            $time = $_POST['time'];
            $img = time() . '_' . $_FILES['image']['name'];
            $target = '../images/' . $img;

            if ($_FILES['image']['name'] == '') {
                $sql = "UPDATE `food_tbl` SET `food_name`= '$name',`price`='$price',`category`='$category',`details`='$details',`time`='$time' WHERE `food_id`='$id'";
            } else {
                $sql = "UPDATE `food_tbl` SET `food_name`= '$name',`price`='$price',`image`='$img',`category`='$category',`details`='$details',`time`='$time' WHERE `food_id`='$id'";
            }


            $res = mysqli_query($this->link, $sql);
            if ($res) {
                move_uploaded_file($_FILES['image']['tmp_name'], $target);
                echo '<div class="alert alert-success">
                <strong>Successfully Updated!</strong>
            </div>';
            } else {
                echo "Not added";
            }
        }
        # code...
    }
}
$obj = new show;
$objShow = $obj->editFunction();
$objInsertInfo = $obj->insertProfileInfo();
$row = mysqli_fetch_assoc($objShow);
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
    .profileImage {
        height: 200px;
        width: 200px;
        object-fit: cover;
        border-radius: 50%;
        margin: 10px auto;
        cursor: pointer;

    }
    </style>
</head>

<body>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-2">
                    <h3 class="float-left font-weight-bold" style="color: #481639">Dashboard</h3>
                    <a href="index.php" class="pt-5 mt-5 font-weight-normal text-dark font-weight-bold  d-block"
                        style="text-decoration: none;">Dashboard</a>

                    <hr>


                    <a href="add.php" class=" font-weight-normal text-dark  d-block" style="text-decoration: none;">Add
                        Food</a>

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

                        <div id="output"></div>

                        <h4 class="font-weight-bold" style="color: #481639">Food Details</h4>
                        <form action="" id="myForm1" enctype="multipart/form-data">
                            <div class="row mt-4">
                                <div class="col-md-7">
                                    <label for="fullname" class="font-weight-bold">Food Name</label>
                                    <input type="text" id="fullname" name="name"
                                        value="<?php echo $row['food_name']; ?>" class="form-control border-0 bg-light">
                                    <label for="price" class="font-weight-bold mt-4">Price</label>
                                    <input type="hidden" name="id" value="<?php echo $row['food_id']; ?>">
                                    <input type="number" id="price" value="<?php echo $row['price']; ?>" name="price"
                                        class="form-control border-0 bg-light">
                                    <label for="category" class="font-weight-bold mt-4">Category</label>
                                    <select name="sub-cat" class="form-control border-0 bg-light" id="category">
                                        <!-- <option value="" disabled selected>Choose category</option> -->
                                        <optgroup label="Burgers">
                                            <option value="chicken" <?php if (strcmp($row['sub_category'], 'chicken') == 0) {
                                                                        echo 'selected';
                                                                    } ?>>Chicken Burger</option>
                                            <option value="beef" <?php if (strcmp($row['sub_category'], 'beef') == 0) {
                                                                        echo 'selected';
                                                                    } ?>>Beef Burger</option>
                                            <option value="vegan" <?php if (strcmp($row['sub_category'], 'vegan') == 0) {
                                                                        echo 'selected';
                                                                    } ?>>Vegan Burger</option>
                                        </optgroup>
                                        <optgroup label="Sides">
                                            <option value="fries" <?php if (strcmp($row['sub_category'], 'fries') == 0) {
                                                                        echo 'selected';
                                                                    } ?>>Fires</option>
                                            <option value="wings" <?php if (strcmp($row['sub_category'], 'wings') == 0) {
                                                                        echo 'selected';
                                                                    } ?>>Wings</option>
                                            <option value="rings" <?php if (strcmp($row['sub_category'], 'rings') == 0) {
                                                                        echo 'selected';
                                                                    } ?>>Onion rings</option>
                                        </optgroup>
                                        <optgroup label="Drinks">
                                            <option value="normal" <?php if (strcmp($row['sub_category'], 'normal') == 0) {
                                                                        echo 'selected';
                                                                    } ?>>Normal</option>
                                            <option value="no-sugar" <?php if (strcmp($row['sub_category'], 'no-sugar') == 0) {
                                                                            echo 'selected';
                                                                        } ?>>Sugar Free</option>
                                        </optgroup>
                                    </select>

                                </div>
                                <div class="col-md-5 text-center">

                                    <img class="profileImage" onclick="triggerClick()" id="profileDisplay"
                                        src="../images/<?php echo $row['image']; ?>" alt="">
                                    <input type="file" accept="image/*" name="image" id="profileImage"
                                        onchange="displayImage(this)" style="display: none;">
                                    <p class="lead">Tap to upload image</p>
                                </div>

                                <div class="col-md-12">
                                    <label for="details" class="font-weight-bold mt-4">Details</label>

                                    <textarea cols="30" rows="10" type="text" id="details" name="details"
                                        class="form-control border-0 bg-light"><?php echo $row['details']; ?></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label for="time" class="font-weight-bold mt-4">Time</label>
                                    <input type="number" id="time" value="<?php echo $row['time']; ?>" name="time"
                                        class="form-control border-0 bg-light">
                                </div>

                            </div>
                            <input class="btn font-weight-bold log_btn btn-lg mt-5" name="submit" type="submit"
                                value="Confirm">

                        </form>
                    </div>

                </div>
            </div>
        </div>
    </section>


    <script src="../js/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>
    <script src="../js/custom.js"></script>
    <script>
    $(document).ready(function() {
        $('#myForm1').submit(function(e) {
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