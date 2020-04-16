<?php include_once 'header.php'; ?>

<?php 
if (isset($_POST['submit'])) {
    $student_name = $_POST['student_name'];
    $student_id = $_GET['id'];

    $query = mysqli_query($mysqli, "UPDATE tbl_students SET student_name = '$student_name' WHERE student_id='$student_id'");

    if ($query) {
        alert("Successfully saved.");
    }
    else {
        alert("Process failed.");
    }
}
?>

<?php if (isset($_GET['id'])) { 
    $student_id = $_GET['id'];
    $query = mysqli_query($mysqli, "SELECT * FROM tbl_students WHERE student_id='$student_id' LIMIT 1");
    if (mysqli_num_rows($query) > 0) {
        $row = mysqli_fetch_array($query);
        $student_name = $row['student_name'];
?>

<div class="row">
    <div class="col-lg-6 custom-center">
        <div class="card">
            <div class="card-header">Edit Student</div>
            <div class="card-body">
                <div class="card-title">
                    <h3 class="text-center title-2">
                        <?php echo $student_name; ?>
                    </h3>
                </div>
                <hr>
                <form action="" method="post">
                    <div class="form-group">
                        <label for="student_name" class="control-label mb-1">Name</label>
                        <input id="student_name" name="student_name" type="text" class="form-control" value="<?php echo $student_name;?>" required>
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