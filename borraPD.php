<?php
	require_once('include/config.php');
	require_once('include/deletePdForm.php');
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
				if (!isset($_SESSION['login']) || ($_SESSION['login'] == false) || $_SESSION['rol'] === 0) {
					echo <<< END
					<p class="red-error">¡Acceso denegado!</p>
					<p class="red-error">Este espacio está reservado para los administradores de la página.</p>
					END;
				}
				else{
			?>
					<h4>¿Vas a eliminar a un director?</h4>
					<?php
						$formularioBorradoPd = new formularioBorradoPd("deletePd", array('action' => 'borraPd.php'));
						$formularioBorradoPd->gestiona()
					?>
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