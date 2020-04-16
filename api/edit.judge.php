<?php include_once 'header.php'; ?>

<?php 
if (isset($_POST['submit'])) {
    $judge_name = $_POST['judge_name'];
    $judge_id = urldecode($_GET['id']);

    $query = mysqli_query($mysqli, "UPDATE tbl_judges SET judge_name = '$judge_name' WHERE judge_id='$judge_id'");

    if ($query) {
        alert("Successfully saved.");
    }
    else {
        alert("Process failed.");
    }
}
?>

<?php if (isset($_GET['id'])) { 
    $judge_id = urldecode($_GET['id']);
    $query = mysqli_query($mysqli, "SELECT * FROM tbl_judges WHERE judge_id='$judge_id' LIMIT 1");
    if (mysqli_num_rows($query) > 0) {
        $row = mysqli_fetch_array($query);
        $judge_id = $row['judge_id'];
        $judge_name = $row['judge_name'];
?>

<div class="row">
    <div class="col-lg-6 custom-center">
        <div class="card">
            <div class="card-header">Edit Judge</div>
            <div class="card-body">
                <div class="card-title">
                    <h3 class="text-center title-2">
                        <?php echo $judge_id; ?>
                    </h3>
                </div>
                <hr>
                <form action="" method="post">
                    <div class="form-group">
                        <label for="judge_name" class="control-label mb-1">Name</label>
                        <input id="judge_name" name="judge_name" type="text" class="form-control" value="<?php echo $judge_name;?>" required>
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