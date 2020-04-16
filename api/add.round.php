<?php include_once 'header.php'; ?>

<?php 
if (isset($_POST['submit'])) {
    $round_name = $_POST['round_name'];
    $competition_id = $_GET['id'];

    $query = mysqli_query($mysqli, "INSERT INTO tbl_rounds (competition_id, round_name, round_status) VALUES ('$competition_id', '$round_name', '0')");

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
            <div class="card-header">Add New Round</div>
            <div class="card-body">
                <div class="card-title">
                    <h3 class="text-center title-2">
                        <?php echo $_GET['name']; ?>
                    </h3>
                </div>
                <hr>
                <form action="" method="post">
                    <div class="form-group">
                        <label for="round_name" class="control-label mb-1">Name</label>
                        <input id="round_name" name="round_name" type="text" class="form-control" required>
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