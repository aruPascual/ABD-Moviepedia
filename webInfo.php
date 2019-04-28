<?php
	require_once('include/config.php');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="style/style.css" />
	<link href='https://fonts.googleapis.com/css?family=Cutive Mono' rel='stylesheet'>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
</head>
<body>
	<div class="main">
		<?php 
			require('include/common/header.php');
			require('include/common/topnav.php');
		?>
		<div class="content">
			<h3>¿Qué hay en la página?</h3>
			<p>En <b>Moviepedia</b> encontrarás información sobre películas y series, su elenco y su director.</p>
			<h4>¿Dónde encuentro la información?</h4>
			<p>Podrás buscar toda esta información desde la pestaña de <i>Búsqueda</i> que hay en el menú de la web.</p>
			<p>Podrás buscar información sobre películas y series tal como su fecha de estreno, su duración, la cantidad de episodios si es una serie, los actores que forman parte del elenco, el director e incluso la valoración que le han dado los usuarios registrados de la página.</p>
			<p>Si buscas a tu actor o actriz favorito también lo podrás encontrar. Busca por su nombre y averigua cuando nació, donde ha participado y la nota que los usuarios le han dado.</p>
			<p>También puedes buscar a ese director de que tanto te gusta su estilo.</p>
			<h4>¿Cómo se puede valorar en <i>Moviepedia?</i></h4>
			<p>Es muy fácil. Para poder valorar cualquier serie/película, parte de su elenco o a algún director debes primero registrarte en la página. Esto es necesario para asegurarnos de que nadie altera de manera caprichosa la nota de su película favorita o de un actor que puede que no le guste. Para poder registrarte, dirijete a la pestaña de <i>Regístrate</i> en la barra del menú.</p>
			<h4>Y las películas que ya he valorado, ¿existe una lista dónde pueda verlas?</h4>
			<p>Si algún día te apetece volver una de las series o películas que más te gustaron, o simplemente se la quieres recomendar a un amigo, entra en tu <i>Perfil</i> y busca entre todas tus valoraciones.</p>
			<br>
			<h3>Github de la web: <a href="https://github.com/aruPascual/ABD-Moviepedia">aruPascual <i><i class="fab fa-github"></i></i> Movipedia</a></h3>
		</div>
		<?php
			require('include/common/footer.php');
		?>
	</div>
</body>
</html>