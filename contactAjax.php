<?php
session_start();
include('class/database.php');
class profile extends database
{
    protected $link;

    public function insertProfileInfo()
    {
        if (isset($_POST['email'])) {

            $name = addslashes(trim($_POST['name']));
            $email = addslashes(trim($_POST['email']));
            $subject = addslashes(trim($_POST['subject']));
            $message = addslashes(trim($_POST['message']));
            $sql = "INSERT INTO `contact_tbl` (`contact_id`, `name`, `email`, `subject`, `message`, `created`) VALUES (NULL, '$name', '$email', '$subject', '$message', CURRENT_TIMESTAMP)";


            $res = mysqli_query($this->link, $sql);
            if ($res) {
                echo '<div class="alert alert-success">
                <strong>Thanks for the response!</strong>
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