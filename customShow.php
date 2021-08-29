<?php
include('class/database.php');
class custom extends database
{
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
}
$obj = new custom;
$objCus = $obj->updateFunction();