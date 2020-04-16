<?php include_once 'header.php'; ?>

<?php 
if (isset($_POST['submit'])) {
    $student_name = $_POST['student_name'];
    $school_id = $_GET['id'];

    $query = mysqli_query($mysqli, "INSERT INTO tbl_students (school_id, student_name) VALUES ('$school_id', '$student_name')");

    if ($query) {
        alert("Successfully added.");
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
            <div class="card-header">Add New Student</div>
            <div class="card-body">
                <div class="card-title">
                    <h3 class="text-center title-2">
                        <?php echo $_GET['name']; ?>
                    </h3>
                </div>
                <hr>
                <form action="" method="post">
                    <div class="form-group">
                        <label for="student_name" class="control-label mb-1">Name</label>
                        <input id="student_name" name="student_name" type="text" class="form-control" required>
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