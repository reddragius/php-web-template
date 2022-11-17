<?php
	if (array_key_exists("page", $_GET))
	{	
		$pageID = $_GET["page"];
	}
	else
	{
		$pageID = "uvod";
	}
?>
<!DOCTYPE html>
<html lang="cs">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Page description.">
	<meta name="robots" content="index">
	
	<link rel="stylesheet" href="css/main.min.css">
	<link rel="stylesheet" href="css/all.min.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link rel="shortcut icon" href="./favicon.png" type="image/x-icon">
	<link href="https://fonts.googleapis.com/css2?family=Kaushan+Script&family=Open+Sans:wght@300;400;700&display=swap" rel="stylesheet">

	<title>BistroLaza | <?php echo $pageID ?></title>
</head>

<body>
	<header>
		<div class="headerMenu">
			<div class="container">
				<a href="?page=uvod" class="logo">BistroLaza</a>
				<div class="menu">
					<ul>
						<li><a href="?page=uvod">O nás</a></li>
						<li><a href="?page=nabidka">Nabídka</a></li>
						<li><a href="?page=galerie">Galerie</a></li>
						<li><a href="?page=kontakt">Kontakty</a></li>
						<li><a href="?page=rezervace">Rezervace</a></li>
						<li><a href="?page=blog">Blog</a></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="headerInfo">
			<div class="container">
				<p class="headerInfoText">BistroLaza</p>
				<p>Jsme tu pro vás již od roku 2000</p>
				<p>
					<a href="#" target="_blank" aria-label="Facebook link" rel="nofollow"><i class="fa-brands fa-facebook-square"></i></a>
					<a href="#" target="_blank" aria-label="Instagram link" rel="nofollow"><i class="fa-brands fa-instagram"></i></a>
					<a href="#" target="_blank" aria-label="Youtube link link" rel="nofollow"><i class="fa-brands fa-youtube"></i></a>
				</p>
			</div>
		</div>
	</header>

	<section>	
		<?php
			echo file_get_contents("$pageID.html"); // nebo require
		?>
	</section>

	<footer>
		<div class="footer">
			<div class="container">
				<div class="footerMenu">
					<h3>Menu</h3>
					<ul>
						<li><a href="?page=uvod">O nás</a></li>
						<li><a href="?page=nabidka">Nabídka</a></li>
						<li><a href="?page=galerie">Galerie</a></li>
						<li><a href="?page=kontakt">Kontakty</a></li>
						<li><a href="?page=rezervace">Rezervace</a></li>
						<li><a href="?page=blog">Blog</a></li>
					</ul>
				</div>
				<div class="contact">
					<h3>Kontakt</h3>
					<div class="footerContact">
						<ul>
							<li><b>BistroLaza</b></li>
							<li>Růžová ulice 55, 123 45</li>
							<li>Veselé Království</li>
						</ul>
					</div>
				</div>
				<div class="footerTime">
					<h3>Otevírací doba</h3>
					<ul>
						<li><b>Po - Pá:</b> 8h - 20h</li>
						<li><b>So:</b> 10h - 22h</li>
						<li><b>Ne:</b> 12h - 20h</li>
					</ul>
				</div>
				<div class="social">
					<h3>Socialní sítě</h3>
					<ul>
						<li>
							<a href="#" target="_blank" aria-label="Facebook link" rel="nofollow">
								<i class="fa-brands fa-facebook-square"></i> Facebook
							</a>
						</li>
						<li>
							<a href="#" target="_blank" aria-label="Instagram link" rel="nofollow">
								<i class="fa-brands fa-instagram"></i> Instagram
							</a>
						</li>
						<li>
							<a href="#" target="_blank" aria-label="Youtube link link" rel="nofollow">
								<i class="fa-brands fa-youtube"></i> Youtube
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="copy">
			<div class="container">
				<div class="copyL">
					&copy; copyright <?php echo date("Y") ?> <b>BistroLaza</b> <span>|</span>
					<a href="#">Ochrana osobních údajů</a> <span>|</span>
					<a href="#">O cookies</a>
				</div>
			</div>
		</div>
	</footer>
</body>

</html>