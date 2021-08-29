<?php
session_start();
include('../class/database.php');
class profile extends database
{
    protected $link;

    public function insertProfileInfo()
    {
        //Update the target item
        if (isset($_POST['name'])) {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $price = $_POST['price'];
            $sub_cat = $_POST['sub-cat'];
            if (strcmp($sub_cat, 'chicken') == 0 || strcmp($sub_cat, 'beef') == 0 || strcmp($sub_cat, 'vegan') == 0) {
                $category = 'main';
            } else if (strcmp($sub_cat, 'fries') == 0 || strcmp($sub_cat, 'wings') == 0 || strcmp($sub_cat, 'rings') == 0) {
                $category = 'side';
            } else {
                $category = 'drink';
            }
            $details = $_POST['details'];
            $time = $_POST['time'];
            $img = time() . '_' . $_FILES['image']['name'];
            $target = '../images/' . $img;

            if ($_FILES['image']['name'] == '') {
                $sql = "UPDATE `food_tbl` SET `food_name`= '$name',`price`='$price',`category`='$category',`sub_category`='$sub_cat',`details`='$details',`time`='$time' WHERE `food_id`='$id'";
            } else {
                $sql = "UPDATE `food_tbl` SET `food_name`= '$name',`price`='$price',`image`='$img',`category`='$category',`sub_category` = '$sub_cat',`details`='$details',`time`='$time' WHERE `food_id`='$id'";
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
$obj = new profile;
$objInsertInfo = $obj->insertProfileInfo();