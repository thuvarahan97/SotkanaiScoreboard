<?php include_once 'header.php'; ?>

<?php 
if (isset($_POST['submit'])) {
    $round_name = $_POST['round_name'];
    $round_status = $_POST['round_status'];
    $round_id = $_GET['id'];

    $query = mysqli_query($mysqli, "UPDATE tbl_rounds SET round_name = '$round_name', round_status = '$round_status' WHERE round_id='$round_id'");

    if ($query) {
        alert("Successfully saved.");
    }
    else {
        alert("Process failed.");
    }
}
?>

<?php if (isset($_GET['id'])) { 
    $round_id = $_GET['id'];
    $query = mysqli_query($mysqli, "SELECT * FROM tbl_rounds WHERE round_id='$round_id' LIMIT 1");
    if (mysqli_num_rows($query) > 0) {
        $row = mysqli_fetch_array($query);
        $round_name = $row['round_name'];
        $round_status = $row['round_status'];
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