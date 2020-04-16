<?php 

include_once 'config.php'; 

$query = mysqli_query($mysqli, "DELETE FROM tbl_competitions WHERE competition_id=".$_POST["id"]);

if ($query) {
    echo true;
}
else {
    echo false;
}

?>