<?php
	require("include/config.php");
	require("include/signupForm.php");
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
			<h3>Regístrate:</h3>

			<?php
				$formulario = new formularioRegistro("registro", array('action' => 'signup.php'));
				$formulario->gestiona();
			?>
		</div>
		<?php
			require("include/common/footer.php");
		?>
	</div>
</body>
</html>