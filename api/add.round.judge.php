<?php include_once 'header.php'; ?>

<?php 
if (isset($_POST['submit'])) {
    $judge_id = $_POST['judge_id'];
    $round_id = $_GET['id'];
    $query = mysqli_query($mysqli, "INSERT INTO tbl_rounds_judges (round_id, judge_id) VALUES ('$round_id', '$judge_id')");
    
    if ($query) {
        alert("Successfully added.");
        echo "<script>location.replace('round.php?round_id=$round_id')</script>";
    }
    else {
        alert("Process failed.");
    }
}
?>

<?php if (isset($_GET['id']) && isset($_GET['name'])) { ?>

<div class="row">
    <div class="col-lg-6 custom-center">
        <div class="card">
            <div class="card-header">Assign Judge to Round</div>
            <div class="card-body">
                <div class="card-title">
                    <h3 class="text-center title-2">
                        <?php echo $_GET['name']; ?>
                    </h3>
                </div>
                <hr>
                <form action="" method="post">
                    <div class="form-group">
                        <label for="judge_id" class="control-label mb-1">Judge</label>
                        <select name="judge_id" id="judge_id" class="form-control" required>
                            <?php 
                                $query = mysqli_query($mysqli, "SELECT * FROM `tbl_judges` ORDER BY judge_id ASC, judge_name ASC");
                                if (mysqli_num_rows($query) > 0) { ?>
                                    <option value="">Please select</option>
                                    <?php while ($row = mysqli_fetch_array($query)) { ?>
                                        <option value = "<?php echo $row['judge_id'] ?>">
                                            <?php 
                                            if ($row['judge_name'] != "") {
                                                echo $row['judge_id']." --- ".$row['judge_name'];
                                            }
                                            else {
                                                echo $row['judge_id'];
                                            } 
                                            ?>
                                        </option>
                                <?php } } else { ?>
                                    <option disabled selected>No judges available.</option>
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
    alert("Invalid Data.");
}
?>

<?php include_once 'footer.php'; ?>