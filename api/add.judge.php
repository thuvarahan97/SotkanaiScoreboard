<?php include_once 'header.php'; ?>

<?php 
if (isset($_POST['submit'])) {
    $judge_id = $_POST['judge_id'];
    $judge_name = $_POST['judge_name'];
    if ($judge_name == "") {
        $query = mysqli_query($mysqli, "INSERT INTO tbl_judges (judge_id) VALUES ('$judge_id')");
    }
    else {
        $query = mysqli_query($mysqli, "INSERT INTO tbl_judges (judge_id, judge_name) VALUES ('$judge_id', '$judge_name')");
    }
    
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
            <div class="card-header">Add New Judge</div>
            <div class="card-body">
                <form action="" method="post">
                    <div class="form-group">
                        <label for="judge_id" class="control-label mb-1">ID</label>
                        <input id="judge_id" name="judge_id" type="text" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="judge_name" class="control-label mb-1">Name</label>
                        <input id="judge_name" name="judge_name" type="text" class="form-control">
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