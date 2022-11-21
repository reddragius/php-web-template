<?php
	require_once "data.php";
	require_once "vendor/autoload.php";

	if (array_key_exists("page", $_GET))
	{	
		$pageID = $_GET["page"];

		if (array_key_exists($pageID, $pageList))
		{	
			//nic nedelat, když stránka existuje
		}
		else
		{	
			//zobraz 404, kdyz stránka neexistuje
			$pageID = "404";
			//a nastav 404, kdyz stránka neexistuje
			http_response_code(404);
		};
	}
	else
	{
		$pageID = array_key_first($pageList); // zobraz první stránku ze seznamu stránek dle aktualniho poradi
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

	<title><?php echo $pageList[$pageID]->getTitle() ?></title>
</head>

<body>
	<header>
		<div class="headerMenu">
			<div class="container">
				<a href="<?php echo array_key_first($pageList);?>" class="logo">BistroLaza</a>
				<div class="menu">
					<?php
						echo "<ul>";
						foreach ($pageList as $id => $page) 
						{
							if ($page->getMenu() != "") // 404
							{
								echo "<li><a href='$id'>{$page->getMenu()}</a></li>";
							}	
						};
						echo "</ul>";
					?>
				</div>
			</div>
		</div>
		<?php
		if ($pageID == array_key_first($pageList))
		{	
			?>
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
		<?php
		}
		?>
	</header>

	<section>
		<?php
			$content = $pageList[$pageID]->getContent();
			echo primakurzy\Shortcode\Processor::process('shortcodes', $content);
		?>
	</section>

	<footer>
		<div class="footer">
			<div class="container">
				<div class="footerMenu">
					<h3>Menu</h3>
					<?php
						echo "<ul>";
						foreach ($pageList as $id => $page)
						{
							if ($page->getMenu() != "") // 404
							{
								echo "<li><a href='$id'>{$page->getMenu()}</a></li>";
							}	
						};
						echo "</ul>";
					?>
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