<?php
	require_once("include/config.php");
	require_once("include/insertPoSForm.php");
	require_once("include/insertPdForm.php");
	require_once("include/updatePoSForm.php");
	require_once("include/updatePdForm.php");
	require_once("include/deletePoSForm.php");
	require_once("include/deletePdForm.php");
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
				if (!isset($_SESSION['login']) || ($_SESSION['login'] == false) || $_SESSION['rol'] === 0) {
					echo <<< END
					<p class="red-error">¡Acceso denegado!</p>
					<p class="red-error">Este espacio está reservado para los administradores de la página.</p>
					END;
				}
				else{
			?>
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
							$formularioInsercionPd = new formularioInsercionPd("insercionPd", array( 'action' => 'adminToolPage.php'));
							$formularioInsercionPd->gestiona();
						?>
					</div>
					<div id="updatePoSDiv">
						<h4>¿Vas a actualizar una película o una serie?</h4>
						<?php
							$formularioActualizacionPoS = new formularioActualizacionPoS("actualizacionPoS", array( 'action' => 'adminToolPage.php'));
							$formularioActualizacionPoS->gestiona();
						?>
					</div>
					<div id="updatePdDiv">
						<h4>¿Vas a actualizar un director?</h4>
						<?php
							$formularioActualizacionPd = new formularioActualizacionPd("actualizacionPd", array( 'action' => 'adminToolPage.php'));
							$formularioActualizacionPd->gestiona();
						?>
					</div>
					<div id="deletePoSDiv">
						<h4>¿Vas a eliminar una película o una serie?</h4>
						<?php
							$formularioBorradoPoS = new formularioBorradoPoS("deletePoS", array('action' => 'adminToolPage.php'));
							$formularioBorradoPoS->gestiona();
						?>
					</div>
					<div id="deletePdDiv">
						<h4>¿Vas a eliminar a un director?</h4>
						<?php
							$formularioBorradoPd = new formularioBorradoPd("deletePd", array('action' => 'adminToolPage.php'));
							$formularioBorradoPd->gestiona()
						?>
					</div>
			<?php
				}
			?>
		</div>
		<?php
			require("include/common/footer.php");
		?>
	</div>
</body>
</html>