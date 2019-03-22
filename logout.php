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
			<form action="include/logout_inc.php" method="post">
			<button type="submit" name="logout-submit">Logout</button></form>
			<p> ¿Ya te marchas? ¡Hasta otro día! </p>
		</div>
		<?php
			require("include/common/footer.php");
		?>
	</div>
</body>
</html>