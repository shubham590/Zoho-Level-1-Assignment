<?php
session_start();
if (!isset($_SESSION['email'])) {
    echo '<script>alert("\nYou are not logged in ! \nWe are redirecting you to Sign In page");
            window.location.href = "signin.php";
            </script>';
}
require_once "config.php";
$email = $_SESSION['email'];
$user_id = $_SESSION['id'];
if (isset($_POST['submitbutton'])) {
    $comment = trim($_POST['story']);
    $sql = "INSERT INTO comments_data (email,comment,user_id,is_logged_in)VALUES(?,?,?,?)";
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssss", $param_email, $param_comment, $param_user_id, $param_is_logged_in);
        $param_email = $email;
        $param_comment = $comment;
        $param_user_id = $user_id;
        $param_is_logged_in = 1;
        if (mysqli_stmt_execute($stmt)) {
            echo '<script>alert("\nComment posted successfully!");
            window.location.href = "home.php";
            </script>';
        } else {
            echo "Something went wrong!";
        }
    }
    mysqli_stmt_close($stmt);
}
$sql2 = "SELECT * FROM comments_data";
$stmt2 = mysqli_query($conn, $sql2);
?>


<!-- HTML CODE -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Comment App</title><br>
        <link rel="stylesheet" type ="text/css" href="style.css">
        <link rel="stylesheet" type ="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
       
</head>
<body>
<div class="parent">
<div class="buttonHolder2">
    <a class="btn btn-danger" href="logout.php" role="button">Logout</a>
</div>
  
     
     
                    
     <div class="commentbox1">
         <br>
         <p><b>What would you like to share with world ?</b><p>
         
         <form action ="" method="post"  >
             <textarea  type="text" name="story" rows="10" cols="20"></textarea>
        </div>
        <div class="submitbutton">
            <button type="submit" name="submitbutton" class="btn btn-primary">Submit</button>
        </div>
    </form>


    <h4>Comments</h4><br>
    <form action ="" method="post"  >
    <div class="filterbutton">
    <button type="submit" name="filterbutton" class="btn btn-dark">Filter</button>
</form>
</div>
    <?php
if (mysqli_num_rows($stmt2) > 0 && (!isset($_POST['filterbutton']))) {
    while ($row = mysqli_fetch_assoc($stmt2)) {
?>
			<div class="single-item2">
                <p><strong><?php echo $row['email']; ?></strong></p>
                <div class="textarea2"><p class="user_comments"><?php echo nl2br($row['comment']); ?></p></div>
                </div>
			<?php
    }
}
?>
            <?php
if (isset($_POST['filterbutton'])) {
    $sql3 = "SELECT * FROM comments_data WHERE is_logged_in=1";
    $stmt3 = mysqli_query($conn, $sql3);
    if (mysqli_num_rows($stmt3) > 0) {
        while ($row1 = mysqli_fetch_assoc($stmt3)) {
?>
			<div class="single-item2">
                <p><strong><?php echo $row1['email']; ?></strong></p>
                <div class="textarea2"><p class="user_comments"><?php echo nl2br($row1['comment']); ?></p></div>
                </div>
			<?php
        }
    }
}
?>
 </div>


    
</body>
</html>
