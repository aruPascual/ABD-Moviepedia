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
			<h3>¿Buscas a un actor o a una actriz en particular?</h3>
			<form id="search" action="include/busqueda_inc.php" method="get">
				<p>¿Cómo deseas hacer la búsqueda?</p>
				<select name="search-by">
					<option value="nombre">Nombre</option>
					<option value="birth-date">Fecha de nacimiento</option>
				</select>
				<?php
					if (isset($_GET['error'])) {
						if ($_GET['error'] == "emptyfields") {
							echo '<p class="red-error">¡Si no escribes nada no sabemos que buscar!</p>';
						}
					}
				?>
				<input type="text" name="data">
				<button type="submit" name="actor-search">Buscar</button>
			</form>
		</div>
		<?php
			require("include/common/footer.php");
		?>
	</div>
</body>
</html>