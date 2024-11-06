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
  $name = isset($_POST['field1']) ? $_POST['field1'] : '';
  $email = isset($_POST['field2']) ? $_POST['field2'] : '';
  $subject = isset($_POST['field4']) ? $_POST['field4'] : '';
  $message = isset($_POST['field5']) ? $_POST['field5'] : '';


  if (!empty($name) && !empty($email) && !empty($subject) && !empty($message)) {
    $sql = "INSERT INTO contact (nume, email, subject, mesaj)
    VALUES ('$name', '$email', '$subject', '$message')";

    if ($conn->query($sql) === TRUE) {
      $success_message = "Mesajul a fost trimis cu succes!";
    } else {
      echo "<p class='error'>Eroare: " . $sql . "<br>" . $conn->error . "</p>";
    }
  }
}
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
      <img id="logo_img" src="logo.png"  >
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
<section id="contact">
    
      <div class="row">
        <div id="contact-info">
          <h2>Contact information:</h2>
          <p><strong>Postal adress</strong></p>
          <p>Street Pinului nr. 45, Alba Iulia, jud. Alba.</p>
          <p><strong>Tel.:</strong> 0751118943</p>
          <p><strong>Email.:</strong> coffeehouse@gmail.com</p>
          <p><strong>Social media:</strong></p>
          <div class="social-media">
            <img src="fb.png">
            <img src="insta.png">
            <img src="twitter.png">
          </div>
        </div>
        <div id="contact-form" >
          <h2>Write a message here:</h2>
          <form action="contact.php" method="POST">
            <label for="field1"><span>Name <span class="required">*</span></span>
              <input type="text" class="input-field" name="field1" value="" />
            </label>
            <label for="field2"><span>Email <span class="required">*</span></span>
              <input type="text" class="input-field" name="field2" value="<?php echo $_SESSION['email']; ?>" />
            </label>

            <label for="field4"><span>Subject</span>
              <select name="field4" class="select-field">
                <option value="general">General</option>
                <option value="web">Feedback</option>
                <option value="design">Complaint</option>
              </select>
            </label>
            
            <label for="field5">
              <span>Message <span class="required">*</span></span>
              <textarea name="field5" class="textarea-field"></textarea>
            </label>

            <input type="submit" name="submit" value="Send" />
                
          </form>
          <?php if (!empty($success_message)) : ?>
            <p class="success"><?php echo $success_message; ?></p>
          <?php endif; ?>
        </div>
      </div>
    </section>
    

  </body>
  </html>
