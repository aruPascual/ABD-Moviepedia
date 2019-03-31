<?php
	require_once("include/config.php");
	require_once("include/searchPoSForm.php");
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
			<h3>¿Buscas una película o una serie?</h3>
			<?php
				$formulario = new formularioBusquedaPoS("search", array('action' => 'searchPoSForm.php'));
				$formulario->gestiona();
			?>
		</div>
		<?php
			require("include/common/footer.php");
		?>
	</div>
</body>
</html>

<!--<form id="search" action="include/busqueda_inc.php" method="get">
				<select name="type">
					<option value="film">Película</option>
					<option value="serie">Serie</option>
				</select>
				<p>¿Cómo deseas hacer la búsqueda?</p>
				<select name="search-by">
					<option value="title">Título</option>
					<option value="genre">Género</option>
					<option value="pd">Director</option>
				</select>
				<?php
					if (isset($_GET['error'])) {
						if ($_GET['error'] == "emptyfields") {
							echo '<p class="red-error">¡Si no escribes nada no sabemos que buscar!</p>';
						}
					}
				?>
				<input type="text" name="data">
				<button type="submit" name="pors-search">Buscar</button>
			</form>-->