<?php
	require_once("include/config.php");
	require_once("include/searchPoSForm.php");
	require_once("include/filmserie.php");
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="style/style.css" />
	<link href='https://fonts.googleapis.com/css?family=Cutive Mono' rel='stylesheet'>
</head>
<body>
	<div class="main">
		<?php 
			require("include/common/header.php");
			require("include/common/topnav.php");
		?>
		<div class="content">
			<?php
				if (isset($_GET['title']) && ($_GET['title'] != null)) {
					$movie = FilmSerie::searchFilmserie($_GET['title']);
					FilmSerie::print($movie);
				}
				else{
			?>
					<h3>¿Buscas una película o una serie?</h3>
			<?php
					$formulario = new formularioBusquedaPoS("search", array('action' => 'buscaPoS.php'));
					$formulario->gestiona();
				}
			?>
		</div>
		<?php
			require("include/common/footer.php");
		?>
	</div>
</body>
</html>