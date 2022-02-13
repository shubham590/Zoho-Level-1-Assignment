<?php
session_start();
if (isset($_SESSION['email'])) {
    header("location:home.php");
    exit;
}
require_once "config.php";
$email = $password = "";
$email_err = "";
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $sql = "SELECT id,email,password FROM userdata WHERE email= ?";
    $sql1 = "UPDATE userdata SET is_logged_in = ? WHERE email=?";
    $sql2 = "UPDATE comments_data SET is_logged_in = ? WHERE email=?";
    $stmt = mysqli_prepare($conn, $sql);
    $stmt1 = mysqli_prepare($conn, $sql1);
    $stmt2 = mysqli_prepare($conn, $sql2);
    mysqli_stmt_bind_param($stmt, "s", $param_email);
    mysqli_stmt_bind_param($stmt1, "ss", $param_is_logged_in, $param_email);
    mysqli_stmt_bind_param($stmt2, "ss", $param_is_logged_in, $param_email);
    $param_email = $email;
    $param_is_logged_in = 1;
    //Try executing statements
    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_store_result($stmt);
        if (mysqli_stmt_num_rows($stmt) == 1) {
            mysqli_stmt_bind_result($stmt, $id, $email, $pass);
            if (mysqli_stmt_fetch($stmt)) {
                if ($password == $pass) {
                    // this means the password is correct. Allow user to login
                    session_start();
                    $_SESSION["email"] = $email;
                    $_SESSION["id"] = $id;
                    mysqli_stmt_execute($stmt1);
                    mysqli_stmt_execute($stmt2);
                    //Redirect user to welcome page
                    header("location: home.php");
                } else {
                    echo '<script>alert("\n      Incorrect Password !");</script>';
                }
            }
        } else {
            echo '<script>alert("\n      Email id is not registered !");</script>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Comment App</title>
        <link rel="stylesheet" type ="text/css" href="style.css">
        <link rel="stylesheet" type ="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">

</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-sm-6">
            <div class=div1>
                <h2>Sign In</h2>
                <p>Don't have an account ?<a href="signup.php"> Sign Up.</a></p>
            </div>
            <form action ="" method="post">
                <div class ="form-group">
                    <label><b>Email</b></label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                    <div class ="form-group">
                    <label><b>Password</b></label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="div2">
                    <p><a href="forgot_password.php">Forgot your Password?</a></p>
                </div>
                <div class="buttonHolder">
                    <button type="submit" name ="login" class="btn btn-primary"> Sign In </button>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>
