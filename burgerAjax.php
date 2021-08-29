<?php
session_start();
include('class/database.php');
class burger extends database
{
    public function cartFunction() //Add inside database function
    {
        if (isset($_POST['id'])) {
            $user = $_SESSION['email'];
            $id = $_POST['id'];
            $price = $_POST['price'];
            $quantity = 1;
            $sql = "INSERT INTO `cart_tbl` (`cart_id`, `cart_item_quantity`, `cart_price`, `cart_item_user`, `food_item`, `created`) VALUES (NULL, '$quantity', '$price', '$user', '$id', CURRENT_TIMESTAMP)"; //Insert the item inside database
            $res = mysqli_query($this->link, $sql);
            if ($res) {

                echo '<div class="alert alert-success">
                <strong>Successfully Added</strong>
              </div>';
            } else {
                echo '<div class="alert alert-danger">
                <strong>Not Added!</strong>
              </div>';
            }
        }

        # code...
    }
}
$obj = new burger;
$objBurger = $obj->cartFunction();