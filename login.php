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
			<h3>Inicia sesión:</h3>
			<?php
				if (isset($_GET['error'])) {
					if ($_GET['error'] == "emptyfields") {
						echo '<p class="red-error"> Campos Vacios </p>';
					}
					else if ($_GET['error'] == "somethingwrong") {
						echo '<p class="red-error"> Usuario o contraseña incorrectos </p>';
					}
					else if ($_GET['error'] == "nouser") {
						echo '<p class="red-error"> Usuario incorrecto </p>';
					}
				}
				/* este condicional y el mensaje en el contenido no debería mostrarse, 
				pero se ha querido controlar por si ocurriese algo inesperado */
				else if (isset($_GET['login'])) {
					if ($_GET['login'] == "success") {
						echo '<p> Login con éxito </p>';
					}
				}
			?>
			<form id="login-signup" action="include/login_inc.php" method="post">
				<input type="text" name="userId" placeholder="Username">
				<input type="password" name="passId" placeholder="Password">
				<button type="submit" name="login-submit"> Enviar </button>
			</form>
		</div>
		<?php
			require("include/common/footer.php");
		?>
	</div>
</body>
</html>