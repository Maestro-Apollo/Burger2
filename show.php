<?php
require_once('class/database.php');
class index extends database
{
    public function foodFunction()
    {
        if (isset($_POST['search'])) {
            $product = trim($_POST['search']);
            $sql = "SELECT * FROM `food_tbl` WHERE food_name like '$product%' ";
        } else {
            $sql = "SELECT * FROM `food_tbl` order by FIELD(category,'main','side','drink')";
        }
        $res = mysqli_query($this->link, $sql);
        $html = "";
        $html .= '<div class="row ">';
        if (mysqli_num_rows($res) > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                $html .= '<div class="col-md-4 wow fadeInUp shadow p-5 mb-5 border">
<div>
    <img src="images/' . $row['image'] . '" class="img-fluid" alt="">
<h4 class="font-weight-bold mt-4" style="color: #481639">
' . $row['food_name'] . '</h4>
<h6 class="font-weight-bold mt-1" style="color: #481639">Price:
    £' . $row['price'] . '</h6>
<p>' . $row['details'] . '</p>
<form action="" method="post">
    <input type="hidden" name="id" value="' . $row['food_id'] . '">
<input type="hidden" name="price" value="' . $row['price'] . '">


</form>
</div>

</div>';
            }
            $html .= '</div>';
            return $html;
        } else {
            $msg = '<p class="lead">No item found</p>';
            return $msg;
        }

        # code...
    }
}
$obj = new index;
echo $obj->foodFunction();