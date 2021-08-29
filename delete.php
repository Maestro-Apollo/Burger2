<?php
session_start();
include('class/database.php');
class profile extends database
{
    protected $link;
    public function cartFunction()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $sql = "DELETE FROM `cart_tbl` WHERE `cart_tbl`.`cart_id` = $id";
            $res = mysqli_query($this->link, $sql);
            if ($res) {
                //$_SERVER['HTTP_REFERER'] will send back user to previous page
                header('Location: ' . $_SERVER['HTTP_REFERER']);
            } else {
                echo "Not Added";
            }
        }
        if (isset($_GET['time'])) {
            $time = $_GET['time'];
            $sql = "DELETE FROM `custom_confirm` WHERE `custom_confirm`.`time` = $time";
            $res = mysqli_query($this->link, $sql);
            $sql = "DELETE FROM custom_cart WHERE `time` = $time ";
            $res = mysqli_query($this->link, $sql);
            if ($res) {
                //$_SERVER['HTTP_REFERER'] will send back user to previous page
                header('Location: ' . $_SERVER['HTTP_REFERER']);
            } else {
                echo "Not Added";
            }
        }



        # code...
    }
}
$obj = new profile;
$objCart = $obj->cartFunction();