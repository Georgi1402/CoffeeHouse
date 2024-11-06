<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "fbtn1zfb";
$dbname = "coffeehouse";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Conexiunea la baza de date a eșuat: " . $conn->connect_error);
}

if (!isset($_SESSION['id_client'])) {
  header("Location: login.php");
  exit();
}

$id_client = $_SESSION['id_client'];
$success_message = "";
$error_message = "";


if (isset($_POST['submit'])) {
  $nume = $_POST['nume'];
  $prenume = $_POST['prenume'];
  $email = $_POST['email'];
  $adresa = $_POST['adresa'];
  $telefon = $_POST['telefon'];


  $query = "UPDATE clienti SET nume='$nume', prenume='$prenume', email='$email', adresa='$adresa', telefon='$telefon' WHERE id_client=$id_client";
  if (mysqli_query($conn, $query)) {
    $success_message = "Informațiile au fost actualizate cu succes.";
  } else {
    $error_message = "Eroare la actualizarea informațiilor: " . mysqli_error($conn);
  }
}


if (isset($_POST['delete'])) {

  $check_query = "SELECT * FROM rezervari WHERE email = '$row[email]'";
  $check_result = mysqli_query($conn, $check_query);

  if (mysqli_num_rows($check_result) > 0) {
    
    $delete_reservations_query = "DELETE FROM rezervari WHERE email = '$row[email]'";
    if (mysqli_query($conn, $delete_reservations_query)) {
     
      $delete_query = "DELETE FROM clienti WHERE id_client = $id_client";
      if (mysqli_query($conn, $delete_query)) {
        
        header("Location: login.php");
        exit();
      } else {
        $error_message = "Eroare la ștergerea contului: " . mysqli_error($conn);
      }
    } else {
      $error_message = "Eroare la ștergerea rezervărilor: " . mysqli_error($conn);
    }
  } else {
  
    $delete_query = "DELETE FROM clienti WHERE id_client = $id_client";
    if (mysqli_query($conn, $delete_query)) {
      
      header("Location: login.php");
      exit();
    } else {
      $error_message = "Eroare la ștergerea contului: " . mysqli_error($conn);
    }
  }
}


if (isset($_POST['logout'])) {

  session_destroy();
  header("Location: login.php");
  exit();
}


$query = "SELECT * FROM clienti WHERE id_client = $id_client";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
  $row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Coffee House</title>
  <link rel="stylesheet" href="stil.css">
  <script src="script.js"></script>
</head>
<body>
  <div id="wrapper">
    <header>
      <img id="logo_img" src="logo.png">
      <nav id="desktop">
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="about.php">About Us</a></li>
          <li><a href="menu.php">Menu</a></li>
          <li><a href="rezervare.php">Reservation</a></li>
          <li><a href="contact.php">Contact</a></li>
          <li><a href="setari.php" id="setting-link"><img id="setari_img" src="setari.png"></a></li>
        </ul>
      </nav>
      <div class="hamburger" >
        <img id="hamburger_logo" src="menu.png" onclick="show_menu()">
    <nav id="mobile">
      <ul onclick="hide_menu()">
        <img src="cross.png" alt="" onclick="hide_menu()" width="64px">
        <a href="index.php">
        <li>Home</li>
        </a>
        <a href="about.php">
        <li>About Us</li>
        </a>
        <a href="menu.php">
        <li>Menu</li>
        </a>
        <a href="rezervare.php">
        <li>Reservation</li>
        </a>
        <a href="contact.php">
        <li>Contact</li>
        </a>
        <a href="setari.php">
        <li>Setari</li>
        </a>
      </ul>
    </nav>
</div>

    </header>
    <div id="profilul_meu">
      <h1>Profilul meu</h1>
      <form method="POST" action="">
        <label for="nume">Nume:</label><br>
        <input type="text" id="nume" name="nume" value="<?php echo $row['nume']; ?>"><br><br>

        <label for="prenume">Prenume:</label><br>
        <input type="text" id="prenume" name="prenume" value="<?php echo $row['prenume']; ?>"><br><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" value="<?php echo $row['email']; ?>"><br><br>

        <label for="adresa">Adresa:</label><br>
        <input type="text" id="adresa" name="adresa" value="<?php echo $row['adresa']; ?>"><br><br>

        <label for="telefon">Telefon:</label><br>
        <input type="text" id="telefon" name="telefon" value="<?php echo $row['telefon']; ?>"><br><br>

        <div class="button-container">
  <input type="submit" name="submit" value="Actualizare informații">
  <input type="submit" name="delete" value="Ștergere cont" onclick="return confirm('Sunteți sigur că doriți să ștergeți contul?')">
  <input type="submit" name="logout" value="Deconectare">
</div>

      </form>

      <?php
        if (!empty($success_message)) {
          echo '<div class="success-message">' . $success_message . '</div>';
        }

        if (!empty($error_message)) {
          echo '<div class="error-message">' . $error_message . '</div>';
        }
      ?>
    </div>
  </div>
  

</body>
</html>

<?php
} else {
  echo "Nu s-au găsit informații despre utilizator.";
}

mysqli_close($conn);
?>
