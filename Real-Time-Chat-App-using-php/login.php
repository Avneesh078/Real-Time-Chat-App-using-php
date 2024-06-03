<?php
include "db.php";
session_start();

if (isset($_POST["name"]) && isset($_POST["phone"])) {
    $name = mysqli_real_escape_string($db, $_POST["name"]);
    $phone = mysqli_real_escape_string($db, $_POST["phone"]);
    
    $q = "SELECT * FROM `users` WHERE uname='$name' AND phone='$phone'";
    $rq = mysqli_query($db, $q);
    
    if ($rq && mysqli_num_rows($rq) == 1) {
        $_SESSION["userName"] = $name;
        $_SESSION["phone"] = $phone;
        header("Location: index.php");
        exit();
    } else {
        $q = "SELECT * FROM `users` WHERE phone='$phone'";
        $rq = mysqli_query($db, $q);
        
        if ($rq && mysqli_num_rows($rq) == 1) {
            echo "<script>alert('Phone number $phone is already taken by another person');</script>";
        } else {
            $q = "INSERT INTO `users` (`uname`, `phone`) VALUES ('$name', '$phone')";
            if (mysqli_query($db, $q)) {
                $_SESSION["userName"] = $name;
                $_SESSION["phone"] = $phone;
                header("Location: index.php");
                exit();
            } else {
                echo "<script>alert('Error registering user');</script>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ChatRoom</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/login.css">
</head>
<body>
  <h1>ChatRoom</h1>
  <div class="login">
    <h2>Login</h2>
    <p>This ChatRoom is the best example to demonstrate the concept of ChatBot and it's completely for beginners.</p>
    <form action="" method="post">
      <h3>UserName</h3>
      <input type="text" placeholder="Enter your name" name="name" required>

      <h3>Mobile No:</h3>
      <input type="number" placeholder="Enter mobile number" min="1111111" max="999999999999999" name="phone" required>

      <button type="submit">Login / Register</button>
    </form>
  </div>
</body>
</html>
