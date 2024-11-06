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
  
    <section id="menu">
      <h1>Our Menu</h1>
      <div class="content">
        <?php
         
          $servername = "localhost";
          $username = "root";
          $password = "fbtn1zfb";
          $dbname = "coffeehouse";

          $conn = new mysqli($servername, $username, $password, $dbname);
          if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
          }

        
          $sql = "SELECT * FROM produse";
          $result = $conn->query($sql);

          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              $id_produs = $row["id_produs"];
              $nume_produs = $row["nume_produs"];
              $descriere = $row["descriere"];
              $pret_unitar = $row["pret_unitar"];
              $imagine_produs = $row["imagine_produs"];

           
              echo "<article>";
              echo "<div class='image'>";
              echo "<img src='$imagine_produs' width='400px'>";
              echo "</div>";
              echo "<div class='text'>";
              echo "<h4>$nume_produs</h4>";
              echo "<p>$descriere</p>";
              echo "<p><strong>Price: $pret_unitar$</strong></p>";
              echo "</div>";
              echo "</article>";
            }
          } else {
            echo "No products found.";
          }

         
          $conn->close();
        ?>
      </div>
    </section>
  </div>
  

</body>
</html>
