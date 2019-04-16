<?php
	require_once("include/config.php");
	require_once("include/searchActorForm.php");
	require_once("include/actor.php");
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
				if (isset($_GET['actorName']) && ($_GET['actorName'] != null)) {
					$actor = Actor::searchActor($_GET['actorName']);
					Actor::print($actor);
				}
				else{
			?>
					<h3>¿Buscas a un actor o a una actriz en particular?</h3>
			<?php
					$formulario = new formularioBusquedaActor("search", array('action' => "buscaActor.php"));
					echo $formulario->gestiona();
				}
			?>
		</div>
		<?php
			require("include/common/footer.php");
		?>
	</div>
</body>
</html>