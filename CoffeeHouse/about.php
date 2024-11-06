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
		<section id="main">
			<section id="about">
				<h1>Our Story</h1>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim idest laborum.</p>
			</section>
	
			<section id="services">
				<h1>Today`s good mood is sponsored by coffee</h1>
				<article>
					<img src="wifi.png" width="64px">
					<h3>Free Wifi</h3>
				</article>
				<article>
					<img src="delivery.png" width="64px">
					<h3>Free Delivery</h3>
				</article>
				<article>
					<img src="suport.png" width="64px">
					<h3>Suport</h3>
				</article>
				<article>
					<img src="serve.png" width="64px">
					<h3>Quality Serve</h3>
				</article>
			</section>
		</section>
	
		

	
</body>
</html>
