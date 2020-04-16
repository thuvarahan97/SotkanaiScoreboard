<?php include_once 'header.php'; ?>

<?php 
if (isset($_POST['submit'])) {
    $school_name = $_POST['school_name'];
    $district_id = $_POST['district_id'];
    $school_id = $_GET['id'];

    $query = mysqli_query($mysqli, "UPDATE tbl_schools SET school_name = '$school_name', district_id = '$district_id' WHERE school_id='$school_id'");

    if ($query) {
        alert("Successfully saved.");
    }
    else {
        alert("Process failed.");
    }
}
?>

<?php if (isset($_GET['id'])) { 
    $school_id = $_GET['id'];
    $query = mysqli_query($mysqli, "SELECT * FROM tbl_schools WHERE school_id='$school_id' LIMIT 1");
    if (mysqli_num_rows($query) > 0) {
        $row = mysqli_fetch_array($query);
        $school_name = $row['school_name'];
        $district_id = $row['district_id'];
?>

<div class="row">
    <div class="col-lg-6 custom-center">
        <div class="card">
            <div class="card-header">Edit School</div>
            <div class="card-body">
                <div class="card-title">
                    <h3 class="text-center title-2">
                        <?php echo $school_name; ?>
                    </h3>
                </div>
                <hr>
                <form action="" method="post">
                    <div class="form-group">
                        <label for="school_name" class="control-label mb-1">Name</label>
                        <input id="school_name" name="school_name" type="text" class="form-control" value="<?php echo $school_name;?>" required>
                    </div>
                    <div class="form-group">
                        <label for="district_id" class="control-label mb-1">District</label>
                        <select name="district_id" id="district_id" class="form-control" required>
                            <?php 
                                $query = mysqli_query($mysqli, "SELECT * FROM `tbl_districts` ORDER BY district_id ASC");
                                if (mysqli_num_rows($query) > 0) { ?>
                                    <option value="">Please select</option>
                                    <?php while ($row = mysqli_fetch_array($query)) { ?>
                                        <option value = "<?php echo $row['district_id'] ?>"
                                        <?php if ($row['district_id']==$district_id) { echo "selected"; }?>>
                                            <?php echo $row['district_name'] ?>
                                        </option>
                                <?php } } else { ?>
                                    <option disabled selected>No districts available.</option>
                                <?php } ?>
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