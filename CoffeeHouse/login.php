<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Coffee House</title>
  <link rel="stylesheet" href="stil.css">
</head>
<body>
  <div id="wrapper">
    <header>
        <img id="logo_img" src="logo.png"  >
    </header>

<h2>Autentificare</h2>
   <div id="login-form">
   <form method="POST" action="">
     <label for="email">Email:</label><br>
     <input type="text" id="email" name="email" required><br><br>
     <label for="parola">Parola:</label><br>
     <input type="password" id="parola" name="parola" required><br><br>
     <input type="submit" name="submit" value="Autentificare">
   <div id="login-register">
        <p>Nu ai cont?? <a href="register.php" class="register-link">Register</a></p>
  </div>
</form>
</div>



<?php
session_start();

$hostname = "localhost";
$username = "root";
$password = "fbtn1zfb";
$bd = "coffeehouse";



$conexiune = mysqli_connect($hostname, $username, $password, $bd) or die("Failed to connect to database");

$error_message = '';



if(isset($_POST['submit'])){
 $email = trim($_POST['email']);
 $parola = trim($_POST['parola']);



 $check_email_query = "SELECT * FROM clienti WHERE email = '$email'";
 $result = mysqli_query($conexiune, $check_email_query);



if(mysqli_num_rows($result) == 1){
 $row = mysqli_fetch_assoc($result);

 if(password_verify($parola, $row['parola'])){
$_SESSION['id_client'] = $row['id_client'];
 $_SESSION['email'] = $row['email'];
 header('Location: index.php');
 exit();
 } else {
 $error_message = 'Parola introdusa nu este corecta!';
}
 } else {
 $error_message = 'Email-ul introdus nu exista in baza de date!';
 header('Location: register.php');
}
}
?>
</body>
</html>
