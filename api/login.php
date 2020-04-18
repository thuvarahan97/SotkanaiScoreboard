<?php include_once 'login.header.php'; ?>

<?php 

$username = "";

if (isset($_POST['submit'])) {
    $username = stripslashes($_POST['username']);
    $password = md5(stripslashes($_POST['password']));

    $query = mysqli_query($mysqli, "SELECT * FROM `tbl_users` WHERE `username` = '$username' AND `password` = '$password'");
    
    if ($query) {
        if (mysqli_num_rows($query) > 0) {
            $row = mysqli_fetch_array($query);

            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['firstname'] = $row['firstname'];
            $_SESSION['lastname'] = $row['lastname'];
            $_SESSION['username'] = $row['username'];

            // alert("Successfully logged in.");
            echo "<script>location.replace('competitions.php')</script>";
        }
        else {
            alert("Incorrect username or password.");
        }
    }
    else {
        alert("Failed to login.");
    }
}
?>

<form action="" method="post">
    <div class="form-group">
        <label>Username</label>
        <input class="au-input au-input--full" type="text" name="username" placeholder="Username" value="<?php echo $username;?>" required>
    </div>
    <div class="form-group">
        <label>Password</label>
        <input class="au-input au-input--full" type="password" name="password" placeholder="Password" required>
    </div>
    <input name="submit" type="submit" class="au-btn au-btn--block au-btn--green m-b-20" value="Login">
</form>
<div class="register-link">
    <p>
        Don't you have account?
        <a href="register.php">Sign Up Here</a>
    </p>
</div>

<?php include_once 'login.footer.php'; ?>