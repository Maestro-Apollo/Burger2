<?php
session_start();
if (isset($_SESSION['admin'])) {
} else {
    header('location:login.php');
}

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

<body class="bg-light">
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-2">
                    <h3 class="float-left font-weight-bold" style="color: #481639">Dashboard</h3>
                    <a href="index.php" class="pt-5 mt-5 font-weight-normal text-dark   d-block"
                        style="text-decoration: none;">Dashboard</a>

                    <hr>
                    <a href="add.php" class=" font-weight-normal text-dark font-weight-bold d-block"
                        style="text-decoration: none;">Add
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

                        <h4 class="font-weight-bold" style="color: #481639">Add Food</h4>
                        <form action="" id="myForm1" enctype="multipart/form-data">
                            <div class="row mt-4">
                                <div class="col-md-7">
                                    <label for="fullname" class="font-weight-bold">Food Name</label>
                                    <input type="text" id="fullname" name="name" class="form-control border-0 bg-light"
                                        required>
                                    <label for="price" step="0.01" class="font-weight-bold mt-4">Price</label>

                                    <input min="0" type="number" id="price" name="price"
                                        class="form-control border-0 bg-light" required>
                                    <label for="category" class="font-weight-bold mt-4">Category</label>
                                    <select name="sub-cat" class="form-control border-0 bg-light" id="category">
                                        <option value="" disabled selected>Choose category</option>
                                        <optgroup label="Burgers">
                                            <option value="chicken">Chicken Burger</option>
                                            <option value="beef">Beef Burger</option>
                                            <option value="vegan">Vegan Burger</option>
                                        </optgroup>
                                        <optgroup label="Sides">
                                            <option value="fries">Fires</option>
                                            <option value="wings">Wings</option>
                                            <option value="rings">Onion rings</option>
                                        </optgroup>
                                        <optgroup label="Drinks">
                                            <option value="normal">Normal</option>
                                            <option value="no-sugar">Sugar Free</option>
                                        </optgroup>
                                    </select>

                                </div>
                                <div class="col-md-5 text-center">

                                    <img class="profileImage" onclick="triggerClick()" id="profileDisplay"
                                        src="../images/placeholder-16-9.jpg" alt="">
                                    <input type="file" accept="image/*" name="image" id="profileImage"
                                        onchange="displayImage(this)" style="display: none;" required>
                                    <p class="lead">Tap to upload image</p>
                                </div>

                                <div class="col-md-12">
                                    <label for="details" class="font-weight-bold mt-4">Details</label>

                                    <textarea cols="30" rows="10" type="text" id="details" name="details"
                                        class="form-control border-0 bg-light" required></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label for="time" class="font-weight-bold mt-4">Time</label>
                                    <input min="0" type="number" id="time" name="time"
                                        class="form-control border-0 bg-light" required>
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
                url: "addAjax.php",
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