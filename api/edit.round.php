<?php include_once 'header.php'; ?>

<?php 
if (isset($_POST['submit'])) {
    $round_name = $_POST['round_name'];
    $round_status = $_POST['round_status'];
    $school_id_1 = $_POST['school_id_1'];
    $school_id_2 = $_POST['school_id_2'];
    $round_id = $_GET['id'];

    $query = mysqli_query($mysqli, "UPDATE tbl_rounds SET round_name = '$round_name', round_status = '$round_status' WHERE round_id='$round_id'");

    if ($school_id_1 != "" && $school_id_2 != "") {
        $query1 = mysqli_query($mysqli, "SELECT * FROM `tbl_rounds_schools` WHERE round_id = '$round_id' LIMIT 1");
        if (mysqli_num_rows($query1) > 0) {
            $query2 = mysqli_query($mysqli, "UPDATE tbl_rounds_schools SET school_id_1 = '$school_id_1', school_id_2 = '$school_id_2' WHERE round_id='$round_id'");
        }
        else {
            $query2 = mysqli_query($mysqli, "INSERT INTO tbl_rounds_schools (round_id, school_id_1, school_id_2) VALUES ('$round_id', '$school_id_1', '$school_id_2')");
        }

        if ($query && $query2) {
            alert("Successfully saved.");
            if (isset($_GET['page']) && $_GET['page'] == 'round') {
                echo "<script>location.replace('round.php?round_id=$round_id')</script>";
            }
            else {
                echo "<script>location.replace('competitions.php')</script>";
            }
        }
        else {
            alert("Process failed.");
        }
    }
    else {
        if ($query) {
            alert("Successfully saved.");
            if (isset($_GET['page']) && $_GET['page'] == 'round') {
                echo "<script>location.replace('round.php?round_id=$round_id')</script>";
            }
            else {
                echo "<script>location.replace('competitions.php')</script>";
            }
        }
        else {
            alert("Process failed.");
        }
    }
}
?>

<?php if (isset($_GET['id'])) { 
    $round_id = $_GET['id'];
    $query = mysqli_query($mysqli, "SELECT A.*, B.school_id_1 AS school_id_1, C.school_name AS school_name_1, B.school_id_2 AS school_id_2, D.school_name AS school_name_2 FROM tbl_rounds A LEFT OUTER JOIN tbl_rounds_schools B ON A.round_id = B.round_id LEFT OUTER JOIN tbl_schools C ON B.school_id_1 = C.school_id LEFT OUTER JOIN tbl_schools D ON B.school_id_2 = D.school_id WHERE A.round_id='$round_id' LIMIT 1");
    if (mysqli_num_rows($query) > 0) {
        $row = mysqli_fetch_array($query);
        $round_name = $row['round_name'];
        $round_status = $row['round_status'];
        $school_id_1 = $row['school_id_1'];
        $school_name_1 = $row['school_name_1'];
        $school_id_2 = $row['school_id_2'];
        $school_name_2 = $row['school_name_2'];
?>

<div class="row">
    <div class="col-lg-6 custom-center">
        <div class="card">
            <div class="card-header">Edit round</div>
            <div class="card-body">
                <div class="card-title">
                    <h3 class="text-center title-2">
                        <?php echo $round_name; ?>
                    </h3>
                </div>
                <hr>
                <form action="" method="post">
                    <div class="form-group">
                        <label for="round_name" class="control-label mb-1">Name</label>
                        <input id="round_name" name="round_name" type="text" class="form-control" value="<?php echo $round_name;?>" required>
                    </div>
                    <div class="form-group">
                        <label for="school_id_1" class="control-label mb-1">School 1</label>
                        <select name="school_id_1" id="school_id_1" class="form-control">
                            <?php 
                                $query = mysqli_query($mysqli, "SELECT * FROM `tbl_schools` ORDER BY school_name ASC");
                                if (mysqli_num_rows($query) > 0) { ?>
                                    <option value="">Please select</option>
                                    <?php while ($row = mysqli_fetch_array($query)) { ?>
                                        <option value = "<?php echo $row['school_id'] ?>"
                                        <?php if ($row['school_id']==$school_id_1) { echo "selected"; }?>>
                                            <?php echo $row['school_name'] ?>
                                        </option>
                                <?php } } else { ?>
                                    <option disabled selected>No schools available.</option>
                                <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="school_id_2" class="control-label mb-1">School 2</label>
                        <select name="school_id_2" id="school_id_2" class="form-control">
                            <?php 
                                $query = mysqli_query($mysqli, "SELECT * FROM `tbl_schools` ORDER BY school_name ASC");
                                if (mysqli_num_rows($query) > 0) { ?>
                                    <option value="">Please select</option>
                                    <?php while ($row = mysqli_fetch_array($query)) { ?>
                                        <option value = "<?php echo $row['school_id'] ?>"
                                        <?php if ($row['school_id']==$school_id_2) { echo "selected"; }?>>
                                            <?php echo $row['school_name'] ?>
                                        </option>
                                <?php } } else { ?>
                                    <option disabled selected>No schools available.</option>
                                <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="round_status" class="control-label mb-1">Round Status</label>
                        <select name="round_status" id="round_status" class="form-control" required>
                            <option value="">Please select</option>
                            <option value="0" <?php if ($round_status=="0") { echo "selected"; }?>>Inactive</option>
                            <option value="1" <?php if ($round_status=="1") { echo "selected"; }?>>Active</option>
                        </select>
                    </div>
                    <br>
                    <div class="form-buttons">
                        <input name="submit" type="submit" class="btn btn-success btn-md" value="Submit">
                        <button type="reset" class="btn btn-danger btn-md">Reset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
    } else {
        alert("Data Not found.");
    }
} else {
    alert("Invalid Data.");
}
?>

<?php include_once 'footer.php'; ?>