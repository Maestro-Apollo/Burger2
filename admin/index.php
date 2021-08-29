<?php
session_start();
if (isset($_SESSION['admin'])) {
} else {
    header('location:login.php');
}
require_once('../class/database.php');
class admin extends database
{
    public function adminFunction()
    {
        //This function will show all the food from database
        $sql = "SELECT * from food_tbl order by FIELD(category, 'main','side','drink')";
        $res = mysqli_query($this->link, $sql);
        if (mysqli_num_rows($res) > 0) {
            return $res;
        } else {
            return false;
        }
        # code...
    }
}
$obj = new admin;
$objFood = $obj->adminFunction();


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
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="../css/style.css">
    <link href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">

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
                        <div class="table-responsive">
                            <table id="Table_ID">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Food Name</th>
                                        <th>Price</th>
                                        <th>Category</th>
                                        <th>Sub-Category</th>
                                        <th>Details</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($objFood) { ?>
                                    <?php while ($row = mysqli_fetch_assoc($objFood)) { ?>
                                    <tr>
                                        <td><img src="../images/<?php echo $row['image']; ?>" alt="" class="w-50"></td>
                                        <td><?php echo $row['food_name']; ?></td>
                                        <td>£<?php echo $row['price']; ?></td>
                                        <td><?php echo $row['category']; ?></td>
                                        <td><?php echo $row['sub_category']; ?></td>
                                        <td><?php echo $row['details']; ?></td>

                                        <td>
                                            <a href="edit.php?id=<?php echo $row['food_id']; ?>"
                                                class="btn btn-success btn-block">Edit</a>
                                            <a href="delete.php?id=<?php echo $row['food_id']; ?>"
                                                class="btn btn-danger btn-block">Delete</a>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                    <?php } ?>

                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <?php include('../layout/footer.php'); ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>
    <script src="//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#Table_ID').DataTable();
    });
    </script>

</body>

</html>