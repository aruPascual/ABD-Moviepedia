<?php
	require_once('include/config.php');
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
			require('include/common/header.php');
			require('include/common/topnav.php');
		?>
		<div class="content">
			<?php
				if (!isset($_SESSION['login']) || ($_SESSION['login'] == false) || ($_SESSION['rol'] == 0)) {
					echo <<< END
					<p class="red-error">¡Acceso denegado!</p>
					<p class="red-error">Este espacio está reservado para los administradores de la página.</p>
					END;
				}
				else{
			?>
					<h3>Bienvenido al panel herramienta del admin</h3>
					<!----------------------------------------------------------------------------------------------------------->
					<div id="PoS">
						<a href="insertaPoS.php">Insertar una Película o Serie</a>
						<a href="actualizaPoS.php">Actualiza una Película o Serie</a>
						<a href="borraPoS.php">Borra una Película o Serie</a>
					</div>
					<!----------------------------------------------------------------------------------------------------------->
					<div id="Actor">
						<a href="insertaActor.php">Insertar un Actor o Actriz</a>
						<a href="actualizaActor.php">Actualiza un Actor o Actriz</a>
						<a href="borraActor.php">Borra un Actor o Actriz</a>
					</div>
					<!----------------------------------------------------------------------------------------------------------->
					<div id="Pd">
						<a href="insertaPd.php">Insertar un Director</a>
						<a href="actualizaPd.php">Actualiza un Director</a>
						<a href="borraPd.php">Borra un Director</a>
					</div>
					<!----------------------------------------------------------------------------------------------------------->
					<div id="Cast">
						<a href="insertaActorComoElenco.php">Insertar un Actor o Actriz como parte de un Elenco</a>
					</div>
			<?php
				}
			?>
		</div>
		<?php
			require('include/common/footer.php');
		?>
	</div>
</body>
</html>