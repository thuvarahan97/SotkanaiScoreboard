<?php 

include_once 'config.php';

$id = mysqli_real_escape_string($mysqli, $_POST['id']);

$query = mysqli_query($mysqli, "DELETE FROM tbl_judges WHERE judge_id='$id'");

if ($query) {
    echo true;
}
else {
    echo false;
}

?>