<?php
session_start();
error_reporting(0);
include('includes/error-reporting.php');


if(!empty($_POST))
{
  $stdid = $_SESSION['stdid'];
    //database settings
    include('includes/config.php');
    foreach($_POST as $field_name => $val)
    {
        //clean post values
        $field_userid = strip_tags(trim($field_name));
        $val = strip_tags(trim(mysql_real_escape_string($val)));
        //from the fieldname:user_id we need to get user_id
        $split_data = explode(':', $field_userid);
        $user_id = $split_data[1];
        $field_name = $split_data[0];
        if(!empty($user_id) && !empty($field_name) && !empty($val))
        {
            //update the values

            $sql="UPDATE tblbooks SET $field_name =:val where StudentId=:stdid and id=:id";//order by tblissuedbookdetails.id desc";
$query = $dbh -> prepare($sql);
//$query-> bindParam(':sid', $sid, PDO::PARAM_STR);
$query-> bindParam(':sid', $stdid, PDO::PARAM_STR);
$query-> bindParam(':val', $val, PDO::PARAM_STR);
$query-> bindParam(':id', $user_id, PDO::PARAM_STR);
$query->execute();

            echo "Updated";
        } else {
            echo "Invalid Requests";
        }
    }
} else {
    echo "Invalid Requests";
}

?>