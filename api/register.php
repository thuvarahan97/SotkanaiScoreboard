<?php include_once 'login.header.php'; ?>

<?php 

$firstname = "";
$lastname = "";
$username = "";

if (isset($_POST['submit'])) {
    $firstname = ucwords(stripslashes($_POST['firstname']));
    $lastname = ucwords(stripslashes($_POST['lastname']));
    $username = stripslashes($_POST['username']);
    $password = stripslashes($_POST['password']);
    $confirm_password = stripslashes($_POST['confirm_password']);

    $query_users = mysqli_query($mysqli, "SELECT * FROM `tbl_users` WHERE username = '$username'");
    if (mysqli_num_rows($query_users) == 0) {
        if ($password == $confirm_password) {
            $password = md5($password);
            $date_registered = date('Y-m-d H:i:s');
            $query = mysqli_query($mysqli, "INSERT INTO `tbl_users` (`firstname`, `lastname`, `username`, `password`, `date_registered`) VALUES ('$firstname', '$lastname', '$username', '$password', '$date_registered')");
        
            if ($query) {
                alert("Successfully registered.");
                echo "<script>location.replace('login.php')</script>";
            }
            else {
                alert("Failed to register.");
            }
        }
        else {
            alert("Passwords do not match.");
        }
    }
    else {
        alert("Username already exists.");
    }
}
?>

<form action="" method="post">
    <div class="form-group">
        <label>First Name</label>
        <input class="au-input au-input--full" type="text" name="firstname" placeholder="First Name" value="<?php echo $firstname;?>" required>
    </div>
    <div class="form-group">
        <label>Last Name</label>
        <input class="au-input au-input--full" type="text" name="lastname" placeholder="Last Name" value="<?php echo $lastname;?>" required>
    </div>
    <div class="form-group">
        <label>Username</label>
        <input class="au-input au-input--full" type="text" name="username" placeholder="Username" value="<?php echo $username;?>" pattern="[A-Za-z0-9]{3,}" title="Three or more letter or number or composite" required>
    </div>
    <div class="form-group">
        <label>Password</label>
        <input class="au-input au-input--full" type="password" name="password" placeholder="Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
    </div>
    <div class="form-group">
        <label>Confirm Password</label>
        <input class="au-input au-input--full" type="password" name="confirm_password" placeholder="Confirm Password" required>
    </div>
    <input name="submit" type="submit" class="au-btn au-btn--block au-btn--green m-b-20" value="Register">
</form>
<div class="register-link">
    <p>
        Already have account?
        <a href="login.php">Sign In</a>
    </p>
</div>

<?php include_once 'login.footer.php'; ?>