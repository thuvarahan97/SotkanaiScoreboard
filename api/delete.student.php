<?php 

include_once 'config.php'; 

$query = mysqli_query($mysqli, "DELETE FROM tbl_students WHERE student_id=".$_POST["id"]);

if ($query) {
    echo true;
}
else {
    echo false;
}

?>