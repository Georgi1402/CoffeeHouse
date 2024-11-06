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
    <h2>Registration</h2>
    <div id="register-form">
      <form action="" method="post">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br><br>
        <label for="firstname">Firstname:</label>
        <input type="text" id="firstname" name="firstname" required><br><br>
        <label for="address">Address:</label>
        <input type="text" id="address" name="address" required><br><br>
        <label for="telefon">Telefon:</label>
        <input type="text" id="telefon" name="telefon" required><br><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>
        <label for="parola">Parolă:</label>
        <input type="password" id="parola" name="parola" required><br><br>
        <label for="confirm_parola">Confirmare parolă:</label>
        <input type="password" id="confirm_parola" name="confirm_parola" required><br><br>
        <input type="submit" name="submit" value="Înregistrare">
        <div id="login-register">
          <p>Ai deja un cont? <a href="login.php" class="login-link">Login</a></p>
        </div>
      </form>
    </div>
  </div>
<?php
$hostname = "localhost";
$username = "root";
$password = "fbtn1zfb";
$bd = "coffeehouse";
$conexiune = mysqli_connect($hostname, $username, $password, $bd ) or die("Eroare la conectare!");
if (!$conexiune) {
 die("Failed ". mysqli_connect_error());
}
  session_start();
  $email="";
  $error_message='';

if (isset($_POST['submit'])){
$email = $parola= $name=$firstname=$address=$telefon="";
$emailErr = $parolaErr= "";
 $confirm_parola = $_POST['confirm_parola'];
$name = $_POST['name'];
$firstname = $_POST['firstname'];
$address = $_POST['address'];
$telefon = $_POST['telefon'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["email"])) {
    $emailErr= "Email is required, please enter your email address";
  } else {
  $email = test_input($_POST["email"]);
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "Invalid email format";
      }
  }
  if (empty($_POST["parola"])) {
      $parolaErr= "Parola is required, please enter a password";
    } else {
    $parola = test_input($_POST["parola"]);
      if (strlen($parola) < 8) {
          $parolaErr = 'Password must be at least 8 characters long.';
      }
    }
  }

  $query = "SELECT * FROM clienti WHERE email='$email'";
  $result = mysqli_query($conexiune, $query);

  if(mysqli_num_rows($result) > 0) {
    
   $error_message='Utilizatorul exista deja. Incercati din nou';
  } else {
  
    if($parola== $confirm_parola) {
      
      $encrypted_password = password_hash($parola, PASSWORD_DEFAULT);
      $query = "INSERT INTO clienti (nume, prenume,adresa,telefon,email, parola) VALUES ('$name', '$firstname', '$address', '$telefon','$email', '$encrypted_password')";
      mysqli_query($conexiune, $query);
     
      echo "Înregistrare cu succes! Vă rugăm să vă autentificați.";
      header("Location: login.php");
      } else {
     
      echo "Parolele nu sunt la fel. Încercați din nou.";
    }
  }
}
function test_input($data) {
  $data = trim($data);
  return $data;
}
?>
</body>
</html>