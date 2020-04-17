<?php 

include_once 'config.php'; 

$query1 = mysqli_query($mysqli, "DELETE FROM tbl_rounds_schools WHERE round_id=".$_POST["id"]);

if ($query1) {
    $query2 = mysqli_query($mysqli, "DELETE FROM tbl_rounds WHERE round_id=".$_POST["id"]);

    if ($query2) {
        echo true;
    }
    else {
        echo false;
    }
}
else {
    echo false;
}

?>