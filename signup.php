<?php
	session_start();
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
				/* contemplamos los distintos errores capturados en signup_inc.php */
				if (isset($_GET['error'])) {
					if ($_GET['error'] == "emptyfields") {
						echo '<p class="red-error"> Campos Vacios </p>';
					}
					else if ($_GET['error'] == "invalidmailuid") {
						echo '<p class="red-error"> Mail y contraseña inválidos </p>';
					}
					else if ($_GET['error'] == "invalidmail") {
						echo '<p class="red-error"> Mail no válido </p>';
					}
					else if ($_GET['error'] == "invaliduid") {			
						echo '<p class="red-error"> Contraseña inválida </p>';
					}
					else if ($_GET['error'] == "passwordcheck") {
						echo '<p class="red-error"> No coinciden las contraseñas </p>';
					}
					else if ($_GET['error'] == "usertaken") {
						echo '<p class="red-error"> Usuario ya existente </p>';
					}
				}
				/* este condicional y el mensaje en el contenido no debería mostrarse, 
				pero se ha querido controlar por si ocurriese algo inesperado */
				else if (isset($_GET['signup'])) {
					if ($_GET['signup'] == "success") {
						echo '<p> Signup con éxito </p>';
					}
				}
			?>
			<form id="login-signup" action="include/signup_inc.php" method="post">
				<input type="text" name="userID" placeholder="Username">
				<input type="text" name="email" placeholder="Mail">
				<input type="password" name="pass" placeholder="Password">
				<input type="password" name="pass-repeat" placeholder="Repeat password">
				<button type="submit" name="signup-submit"> Enviar </button>
			</form>
		</div>
		<?php
			require("include/common/footer.php");
		?>
	</div>
</body>
</html>