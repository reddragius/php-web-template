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

		// zpracovani tlacitka newpage-button
		if (array_key_exists("newpage-button", $_GET))
		{
			$instanceCurrentPage = new Page("", "","");
		}

		// zpracovani mazani
		if (array_key_exists("delete", $_GET))
		{
			$instanceCurrentPage->delete();
			header("Location: ?");
		}

		// zpracovani formu pro save-button
		if (array_key_exists("save-button", $_POST))
		{
			// ulozit puvodni page ID nez si ho prepisu
			$originPageID = $instanceCurrentPage->pageID;

			$instanceCurrentPage->pageID = $_POST["pageID"];
			$instanceCurrentPage->title = $_POST["title"];
			$instanceCurrentPage->menu = $_POST["menu"];
			$instanceCurrentPage->save($originPageID);

			// ukladani obsahu stranky
			$content = $_POST["content"];
			$instanceCurrentPage->setContent($content);

			// presmerujeme se na url s editaci stranky s novym id
			header("Location: ?page=".$instanceCurrentPage->pageID);
		}
		
		// zpracovani pozadavku zmeny poradi stranek z javascriptu (ajaxem)
		if (array_key_exists("orderPage", $_GET))
		{
			$orderPage = $_GET["orderPage"];

			// zavolani funkce pro nastaveni poradi a ulozeni do db
			Page::setPageOrder($orderPage);

			// odpovime javascriptu ze je to ok
			echo "OK";
			// skript ukoncime aby do javascriptu se negeneroval zbytek
			// html stranky
			exit;
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
	
	<link rel="stylesheet" href="css/all.min.css"><!-- css fontawesome  -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link rel="shortcut icon" href="./favicon.png" type="image/x-icon">
	<link href="https://fonts.googleapis.com/css2?family=Kaushan+Script&family=Open+Sans:wght@300;400;700&display=swap" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
 	<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
	<link rel="stylesheet" href="css/admin.css">
	
	<title>Admin sekce</title>
</head>
<body>
	<div class="admin-body">
		<?php
			if (array_key_exists("loggedInUser", $_SESSION) == false) 
			{
				// odhlaseny uzivatel
				?>
				<main class="form-signin">
					<form method="post">
						<h1 class="h3 mb-3 fw-normal">Přihlašte se prosím</h1>

						<?php if ($error != "") { ?>
							<div class="alert alert-danger" role="alert">
								<?php echo $error; ?>
							</div>
						<?php } ?>

						<div class="form-floating">
							<input name="user" type="text" class="form-control" id="floatingInput" placeholder="login">
							<label for="floatingInput">Přihlašovací jméno</label>
						</div>
						<div class="form-floating">
							<input name="password" type="password" class="form-control" id="floatingPassword" placeholder="heslo">
							<label for="floatingPassword">Heslo</label>
						</div>

						<button name="login-button" class="w-100 btn btn-lg btn-primary" type="submit">Přihlásit</button>
					</form>
            	</main>
				<?php 
			} 
			else 
			{
				//sekce pro prihlasene uzivatele
				echo "<main class='admin'>";

				?>
				<div class="container">
					<header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
						<div>Přihlášený uživatel: <?php echo $_SESSION["loggedInUser"]; ?></div>
	
						<div class="col-md-3 text-end">
							<form method='post'>
								<button name='logout-button' class="btn btn-outline-primary me-2">Odhlásit</button>
							</form>
						</div>
					</header>
				</div>
	
				<?php
				// list pages to edit
				echo "<ul id='pages' class='list-group'>";
					foreach ($pageList as $pageID => $page) 
					{
						$active = '';
						$buttonClass = '';
						if ($page == $instanceCurrentPage)
						{
							$active = 'active';
							$buttonClass = 'btn-secondary';
						}
						echo "<li class='list-group-item $active' id='$pageID'>
								<a href='?page=$pageID' class='btn $buttonClass'><i class='fa-solid fa-pen-to-square'></i></a>
								<a href='?page=$pageID&delete' class='btn $buttonClass'><i class='fa-solid fa-trash-can'></i></i></a>
								<a href='$pageID' class='btn $buttonClass' target='_blank'><i class='fa-solid fa-eye'></i></a>
								<span>$pageID</span>
							</li>";
					};
				echo "</ul>";

				// formular s tlacitkem pro pridani stranky
				?>
				<div class="container">
					<header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4">
						<div class="col-md-3 text-start">
							<form>
								<button name='newpage-button' class="btn btn-outline-primary me-2"><i class='fa-solid fa-file-circle-plus'></i> Nová stránka</button>
							</form>
						</div>
					</header>
				</div>
				<?php
				
				// editacni formular tinymce
				if (isset($instanceCurrentPage))
				{
					echo "<h2>";
					if ($instanceCurrentPage->pageID == "")
					{
						echo "Přidávání nové stránky";
					} 
					else {
						echo "Editace stránky: $instanceCurrentPage->pageID";
					}
					echo "</h2>";
					?>
					<form method="post">
						<div class="form-floating mb-1">
							<input
								class="form-control"
								type="text"
								name="pageID"
								id="pageID"
								value="<?php echo htmlspecialchars($instanceCurrentPage->pageID) ?>"
								placeholder="ID"
							>
							<label for="pageID">ID:</label>
						</div>
						<div class="form-floating mb-1">	
							<input
								class="form-control"
								type="text"
								name="title"
								id="title"
								value="<?php echo htmlspecialchars($instanceCurrentPage->title) ?>"
								placeholder="Titulek"
							>
							<label for="title">Titulek:</label>
						</div>
						<div class="form-floating mb-1">
							<input
								class="form-control"
								type="text"
								name="menu"
								id="menu"
								value="<?php echo htmlspecialchars($instanceCurrentPage->menu) ?>"
								placeholder="Menu"
							>
							<label for="menu">Menu:</label>
						</div>

						<textarea id="myTinymce" name="content" cols="80" rows="15" ><?php
							echo htmlspecialchars($instanceCurrentPage->getContent());
						?></textarea>
						<br>
						<button name="save-button" class="btn btn-primary">Uložit</button>
					</form>
					<script src="vendor/tinymce/tinymce/tinymce.min.js"></script>
					<script>
						tinymce.init({
							selector: '#myTinymce',
							language: 'cs',
							language_url: '<?php echo dirname($_SERVER["PHP_SELF"]); ?>/vendor/tweeb/tinymce-i18n/langs/cs.js',
							height: '50vh', // vyska okna editoru
							entity_encoding: "raw", // fix kodovani
							verify_html: false, // fix fontawesome icon - empty space
							content_css: [
								"css/main.min.css",
								"css/all.min.css", 
								"https://fonts.googleapis.com/css2?family=Kaushan+Script&family=Open+Sans:wght@300;400;700&display=swap"
							], //load my css, fontawesome css, google font css
							plugins: 'advlist anchor autolink charmap code colorpicker contextmenu directionality emoticons fullscreen hr image imagetools insertdatetime link lists nonbreaking noneditable pagebreak paste preview print save searchreplace tabfocus table textcolor textpattern visualchars',
							toolbar1: "insertfile undo redo | styleselect | fontselect | fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | forecolor backcolor",
							toolbar2: "link unlink anchor | fontawesome | image media | responsivefilemanager | preview code",
							// filemanager - adds a new button for upload. Its needs directories: ./upload/source & ./upload/thumbs
							external_plugins: {
								'responsivefilemanager': '<?php echo dirname($_SERVER['PHP_SELF']); ?>/vendor/primakurzy/responsivefilemanager/tinymce/plugins/responsivefilemanager/plugin.min.js',
							},
							external_filemanager_path: "<?php echo dirname($_SERVER['PHP_SELF']); ?>/vendor/primakurzy/responsivefilemanager/filemanager/",
							filemanager_title: "Správce souborů",
						});
					</script>
					<?php
				}
				echo "</main>";
			}
		?>
	</div>
	<script src="js/admin.js"></script>
</body>
</html>