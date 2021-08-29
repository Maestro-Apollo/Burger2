<?php
session_start();
include('../class/database.php');
class profile extends database
{
    protected $link;
    public function cartFunction()
    {
        //This function will delete the items from dashboard
        $id = $_GET['id'];
        $sql = "DELETE FROM `food_tbl` WHERE `food_tbl`.`food_id` = $id";
        $res = mysqli_query($this->link, $sql);
        if ($res) {

            header('Location: ' . $_SERVER['HTTP_REFERER']);
        } else {
            echo "Not Added";
        }

        # code...
    }
}
$obj = new profile;
$objCart = $obj->cartFunction();