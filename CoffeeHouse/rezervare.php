<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "fbtn1zfb";
$dbname = "coffeehouse";


$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Conexiune esuata: " . $conn->connect_error);
}

$success_message = '';

if (isset($_POST['submit'])) {
  $email = isset($_SESSION['email']) ? $_SESSION['email'] : '';
  $data_rezervarii = isset($_POST['data_rezervarii']) ? $_POST['data_rezervarii'] : '';
  $ora_rezervarii = isset($_POST['ora_rezervarii']) ? $_POST['ora_rezervarii'] : '';
  $nr_persoane = isset($_POST['nr_persoane']) ? $_POST['nr_persoane'] : '';

  
  if (!empty($email) && !empty($data_rezervarii) && !empty($ora_rezervarii) && !empty($nr_persoane)) {
    if (isset($_GET['edit_id'])) {
     
      $id_rezervare = $_GET['edit_id'];
      $sql = "UPDATE rezervari SET email='$email', data_rezervarii='$data_rezervarii', ora_rezervarii='$ora_rezervarii', nr_persoane='$nr_persoane' WHERE id_rezervare='$id_rezervare'";
      $success_message = "Rezervarea a fost modificată cu succes!";
    } else {
    
      $sql = "INSERT INTO rezervari (email, data_rezervarii, ora_rezervarii, nr_persoane) VALUES ('$email', '$data_rezervarii', '$ora_rezervarii', '$nr_persoane')";
      $success_message = "Rezervarea a fost efectuată cu succes!";
    }

    if ($conn->query($sql) === TRUE) {
      $_SESSION['email'] = $email; 
    } else {
      echo "<p class='error'>Eroare: " . $sql . "<br>" . $conn->error . "</p>";
    }
  }
}

if (isset($_GET['delete'])) {
  $id_rezervare = $_GET['delete'];

  $query = "DELETE FROM rezervari WHERE id_rezervare='$id_rezervare'";
  $result = mysqli_query($conn, $query);

  if (!$result) {
    echo "<p class='error'>Eroare: " . mysqli_error($conn) . "</p>";
  } else {
    $success_message = "Ștergere efectuată cu succes!";
  }
}

if (isset($_GET['edit_id'])) {
  $edit_id = $_GET['edit_id'];

 
  $query = "SELECT * FROM rezervari WHERE id_rezervare = '$edit_id' AND email = '".$_SESSION['email']."'";
  $result = mysqli_query($conn, $query);

  if ($result && mysqli_num_rows($result) > 0) {
    $rezervare = mysqli_fetch_assoc($result);

    $email = $rezervare['email'];
    $data_rezervarii = $rezervare['data_rezervarii'];
    $ora_rezervarii = $rezervare['ora_rezervarii'];
    $nr_persoane = $rezervare['nr_persoane'];
  }
}


$query = "SELECT * FROM rezervari WHERE email='" . $_SESSION['email'] . "'";
$rezultat = mysqli_query($conn, $query) or die('Eroare');
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
    <section id="rezervare">
      <div id="rezervare-form">
        <form action="" method="POST">

          <label for="data_rezervarii" class="required-label">Data rezervării:</label>
          <input type="date" id="data_rezervarii" name="data_rezervarii" value="<?php echo isset($data_rezervarii) ? $data_rezervarii : ''; ?>" required><br>

          <label for="ora_rezervarii" class="required-label">Ora rezervării:</label>
          <input type="time" id="ora_rezervarii" name="ora_rezervarii" value="<?php echo isset($ora_rezervarii) ? $ora_rezervarii : ''; ?>" required><br>

          <label for="nr_persoane" class="required-label">Număr persoane:</label>
          <input type="number" id="nr_persoane" name="nr_persoane" min="1" value="<?php echo isset($nr_persoane) ? $nr_persoane : ''; ?>" required><br>

          <input type="hidden" name="id_rezervare" value="<?php echo isset($_GET['edit_id']) ? $_GET['edit_id'] : ''; ?>">

          <input type="submit" name="submit" value="Trimite">
        </form>
      </div>
<div class="table-wrapper">
      <table>
        <tr>
          <th>Email</th>
          <th>Data rezervarii</th>
          <th>Ora rezervarii</th>
          <th>Numar persoane</th>
          <th>Acțiuni</th>
        </tr>
        <?php
        if ($rezultat && mysqli_num_rows($rezultat) > 0) {
          while ($row = mysqli_fetch_assoc($rezultat)) {
            echo "<tr>";
            echo "<td>".$row['email']."</td>";
            echo "<td>".$row['data_rezervarii']."</td>";
            echo "<td>".$row['ora_rezervarii']."</td>";
            echo "<td>".$row['nr_persoane']."</td>";
            echo "<td><a href='rezervare.php?edit_id=".$row['id_rezervare']."'>Edit</a> | <a href='rezervare.php?delete=".$row['id_rezervare']."' onclick=\"return confirm('Sigur doriți să ștergeți rezervarea?');\">Delete</a></td>";
            echo "</tr>";
          }
        } else {
          echo "<tr><td colspan='5'>Nu există rezervări.</td></tr>";
        }
        ?>
      </table>
    </div>

      <?php
      if (!empty($success_message)) {
        echo "<p class='success-message'>".$success_message."</p>";
      }
      ?>
    </section>

    
  </div>
  

</body>
</html>
