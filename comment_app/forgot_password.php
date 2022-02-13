<?php
session_start();
require_once "config.php";
$email = $secret = "";
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = trim($_POST['email']);
    $secret = trim($_POST['secret']);
    $sql = "SELECT id,email,password,secret FROM userdata WHERE email= ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $param_email);
    $param_email = $email;
    //Try executing statements
    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_store_result($stmt);
        if (mysqli_stmt_num_rows($stmt) == 1) {
            mysqli_stmt_bind_result($stmt, $id, $email, $pass, $hashed_secret);
            if (mysqli_stmt_fetch($stmt)) {
                if (password_verify($secret, $hashed_secret)) {
                    // this means the password is corrct. Allow user to login
                    echo '<script>alert("\n      Your password is : ' . $pass . '");</script>';
                    //Redirect user to welcome page
                    
                } else {
                    echo '<script>alert("\n      Incorrect Secret Code !");</script>';
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
            <div class="div1">
            <h2>Forgot Password</h2>
        </div>
            <form action ="" method="post">
                <div class ="form-group">
                    <label><b>Email</b></label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                    <div class ="form-group">
                    <label><b>Secret Code</b></label>
                    <input type="password" name="secret" class="form-control" required>
                
                
                    <div class="buttonHolder">
                        <button type="submit" class="btn btn-primary"> Sign In </button>
                    </div>
            </form>
        </div>
    </div>
</div>

</body>
</html