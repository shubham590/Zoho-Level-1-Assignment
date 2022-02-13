<?php
require_once "config.php";
$email = $password = $secret = "";
$email_err = "";
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $sql = "SELECT id FROM userdata WHERE email= ?";
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $param_email);
        $param_email = trim($_POST['email']);
        //Try executing statements
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_store_result($stmt);
            if (mysqli_stmt_num_rows($stmt) == 1) {
                $email_err = "This email id is already registered";
                echo '<script>alert("\n   This email id is already registered");</script>';
            } else {
                $email = trim($_POST['email']);
            }
        } else {
            echo "Something went wrong";
        }
    }
    mysqli_stmt_close($stmt);
    if (empty($email_err)) {
        $password = trim($_POST['password']);
        $secret = trim($_POST['secret']);
        $sql = "INSERT INTO userdata (email,password,secret)VALUES(?,?,?)";
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sss", $param_email, $param_password, $param_secret);
            //Set Parameters
            $param_email = $email;
            $param_password = $password;
            $param_secret = password_hash($secret, PASSWORD_DEFAULT);
            //Try to execute query
            if (mysqli_stmt_execute($stmt)) {
                echo '<script>alert("\nSign Up successful ! \nWe are redirecting you to Sign In page");
            window.location.href = "signin.php";
            </script>';
            } else {
                echo "Something went wrong!";
            }
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($conn);
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
        <script> if ( window.history.replaceState ) 
        { 
            window.history.replaceState( null, null, window.location.href ); 
        } 
        </script>

</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-sm-6">
            <div class="div1">
                <h2>Sign Up</h2>
                <p>Already have an account ?<a href="signin.php"> Sign In.</a></p>
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
                    <div class ="form-group">
                    <label><b>Secret</b></label>
                    <input type="password" name="secret"  class="form-control" required>
                </div>
                
                <div class="buttonHolder">
                    <button type="submit" class="btn btn-primary"> Sign Up </button>
                </div>
                <div class="div1">
                    <p>By clicking the "Sign Up" button, you are creating an account and, you agree to the Terms of Use.</p>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>