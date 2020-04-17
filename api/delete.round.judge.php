<?php 

include_once 'config.php'; 

$round_id = $_POST['round_id'];
$judge_id = mysqli_real_escape_string($mysqli, $_POST['judge_id']);

$query = mysqli_query($mysqli, "DELETE FROM tbl_rounds_judges WHERE round_id='$round_id' AND judge_id='$judge_id'");

if ($query) {
    echo true;
}
else {
    echo false;
}

?>