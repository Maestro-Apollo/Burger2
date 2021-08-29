<?php
session_start();
include('../class/database.php');
class profile extends database
{
    protected $link;

    public function insertProfileInfo()
    {
        //All the data from add.php will insert here through ajax
        if (isset($_POST['name'])) {

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

            $sql = "INSERT INTO `food_tbl` (`food_id`, `food_name`, `image`, `price`, `category`, `sub_category`, `details`, `time`) VALUES (NULL, '$name', '$img', '$price', '$category', '$sub_cat', '$details', '$time')";


            $res = mysqli_query($this->link, $sql);
            if ($res) {
                move_uploaded_file($_FILES['image']['tmp_name'], $target);
                echo '<div class="alert alert-success">
                <strong>Successfully Added!</strong>
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