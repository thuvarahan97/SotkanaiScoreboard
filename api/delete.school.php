<?php 

include_once 'config.php'; 

$query = mysqli_query($mysqli, "DELETE FROM tbl_schools WHERE school_id=".$_POST["id"]);

if ($query) {
    echo true;
}
else {
    echo false;
}

?>