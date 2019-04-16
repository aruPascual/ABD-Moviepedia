<?php
	require_once("include/config.php");
	require_once("include/searchPdForm.php");
	require_once("include/pd.php");	
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
				if (isset($_GET['pdName']) && ($_GET['pdName'] != null)) {
					$pd = Pd::searchPd($_GET['pdName']);
					Pd::print($pd);
				}
				else {
			?>
					<h3>¿Buscas a un director en particular?</h3>
			<?php
					$formulario = new formularioBusquedaPd("search", array('action' => "buscaPd.php"));
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