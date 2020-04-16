<?php include_once 'header.php'; ?>

<?php 
if (isset($_POST['submit'])) {
    $competition_name = $_POST['competition_name'];
    $district_id = $_POST['district_id'];

    $query = mysqli_query($mysqli, "INSERT INTO tbl_competitions (competition_name, district_id) VALUES ('$competition_name','$district_id')");

    if ($query) {
        alert("Successfully added.");
    }
    else {
        alert("Process failed.");
    }
}
?>

<div class="row">
    <div class="col-lg-6 custom-center">
        <div class="card">
            <div class="card-header">Add New Competition</div>
            <div class="card-body">
                <form action="" method="post">
                    <div class="form-group">
                        <label for="competition_name" class="control-label mb-1">Name</label>
                        <input id="competition_name" name="competition_name" type="text" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="district_id" class="control-label mb-1">District</label>
                        <select name="district_id" id="district_id" class="form-control" required>
                            <?php 
                                $query = mysqli_query($mysqli, "SELECT * FROM `tbl_districts` ORDER BY district_id ASC");
                                if (mysqli_num_rows($query) > 0) { ?>
                                    <option value="">Please select</option>
                                    <?php while ($row = mysqli_fetch_array($query)) { ?>
                                        <option value = "<?php echo $row['district_id'] ?>">
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

<?php include_once 'footer.php'; ?>