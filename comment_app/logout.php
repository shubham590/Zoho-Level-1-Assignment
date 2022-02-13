<?php
    session_start();
    $email=$_SESSION['email'];
    require_once "config.php";
    $sql1="UPDATE userdata SET is_logged_in = ? WHERE email=?"; 
    $stmt1=mysqli_prepare($conn,$sql1);
    $sql2="UPDATE comments_data SET is_logged_in = ? WHERE email=?"; 
    $stmt2=mysqli_prepare($conn,$sql2);
    mysqli_stmt_bind_param($stmt1, "ss", $param_is_logged_in,$param_email);
    mysqli_stmt_bind_param($stmt2, "ss", $param_is_logged_in,$param_email);
    $param_is_logged_in=0;
    $param_email=$email;
    mysqli_stmt_execute($stmt1);
    mysqli_stmt_execute($stmt2);
    $_SESSION = array(); 
    session_destroy(); 
    header("Location: signin.php"); 
    exit();
?>