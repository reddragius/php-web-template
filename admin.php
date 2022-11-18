<?php
	session_start();
	require_once "data.php";

	$userlist = [
		"Demo" => "Demo",
	];
	$error = null;

	// login-button
	if (array_key_exists("login-button", $_POST))
	{	
		$user = $_POST["user"];
		$password = $_POST["password"];
		
		// zjisti jestli dany klic($user) je v poli $userlist
		$userExist = array_key_exists($user, $userlist); 

		if ($userExist && $userlist[$user] == $password)  
		{
			// platne prhlasovaci udaje
			$_SESSION["loggedInUser"] = $user;
			header("Location: ?");
		}
		else 
		{
			// neplatne prihlasovaci udaje
			$error = "Nesprávné přihlašovací údaje.";
		}
	}
	
	// logout-button
	if (array_key_exists("logout-button", $_POST)) 
	{
		unset($_SESSION["loggedInUser"]);
		header("Location: ?");
	}

	// editace pouze pro prihlaseneho usera
	if (array_key_exists("loggedInUser", $_SESSION)) 
	{	
		$instanceCurrentPage = null;
		// zpracovani vyberu aktualni stranky
		if (array_key_exists("page", $_GET)) 
		{
			$pageID = $_GET["page"];
			$instanceCurrentPage = $pageList[$pageID];
		}

		// zpracovani formu pro ulozeni
		if (array_key_exists("save-button", $_POST))
		{
			$content = $_POST["content"];
			$instanceCurrentPage->setContent($content);
		}
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

	<title>Admin sekce</title>
</head>
<body>
	<?php
		if (array_key_exists("loggedInUser", $_SESSION) == false) 
		{
			// odhlaseny uzivatel
			?>
			<form method="post">
				<label>Přihl. jméno: <input type="text" name="user"></label><br>
				<label>Heslo: <input type="password" name="password"></label><br>
				<button name="login-button">Login</button>
			</form> 
			<?php 
				echo $error;
		} 
		else 
		{
			// sekce pro prihlasene uzivatele
			echo "<h2>Přihlášen uživatel: {$_SESSION["loggedInUser"]}</h2>";
			echo "<form method='post'>
					<button name='logout-button'>Logout</button>
				</form>";
			echo "<br>";
			echo "<ul>";
				foreach ($pageList as $pageID => $page) 
				{
					echo "<li>
							<a href='?page=$pageID'>$pageID</a> | 
							<a href='$pageID' target='_blank'><i class='fa-solid fa-eye'></i></a>
						</li>";
				};
			echo "</ul>";
			
			// editacni formular, zobrazit pokud je nejaka stranka vybrana k editaci
			if (isset($instanceCurrentPage))
			{
				echo "<h2>Editace stránky: $instanceCurrentPage->pageID</h2>";
				?>
				<form method="post">
					<textarea name="content" cols="80" rows="15"><?php
						echo htmlspecialchars($instanceCurrentPage->getContent());
					?></textarea><br>
					<button name="save-button">Uložit</button>
				</form>
				<?php
			}
		}
	?>
</body>
</html>