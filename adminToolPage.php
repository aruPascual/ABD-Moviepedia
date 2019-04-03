<?php
	require_once("include/searchPoSForm.php");
	require_once("include/insertPoSForm.php");
	require_once("include/insertPdForm.php");
	require_once("include/config.php");
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
			<h3>Bienvenido al panel herramienta del admin</h3>
			<div id="insertPoSDiv">
				<h4>¿Vas a insertar una película o una serie?</h4>
				<?php $formularioInsercionPoS = new formularioInsercionPoS("insercionPoS", array( 'action' => 'adminToolPage.php'));
					$formularioInsercionPoS->gestiona();
				?>
			</div>
			<div id="insertActorDiv">
				<h4>¿Vas a insertar un actor o actriz?</h4>
			</div>
			<div id="insertPdDiv">
				<h4>¿Vas a insertar un director?</h4>
				<?php
					$formularioInsercionPoS = new formularioInsercionPd("insercionPd", array( 'action' => 'adminToolPage.php'));
					$formularioInsercionPoS->gestiona();
				?>
			</div>
		</div>
		<?php
			require("include/common/footer.php");
		?>
	</div>
</body>
</html>