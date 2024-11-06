
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
<section id="hero">
	<div id="content-hero">
		<h1>Welcome to</h1>
		<h2>Coffee House</h2>
		<a href="rezervare.php" class="btn">Reserve now</a>
	</div>
</section>

<?php
  session_start();

  
  if(!isset($_SESSION['email'])) {
  
    header("Location: register.php");
  }

  
?>
</body>
</html>
