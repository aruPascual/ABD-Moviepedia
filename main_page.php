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
			<h3>Moviepedia: tu catálogo de series y películas.</h3>
			<p>¿No sabes qué ver? En Moviepedia encontrarás un gran catálogo de series y películas. 
			Además podrás buscar tus actores y actrices favoritos y saber cuáles han sido sus apariciones.</p>
			<p>No solo eso. También podrás valorar  todo aquello que ya hayas visto. ¿No sientes curiosidad
			por saber que rating tienen tus series y películas favoritas?</p>
		</div>
		<?php
			require('include/common/footer.php');
		?>
	</div>
</body>
</html>