<?php
	require_once('include/config.php');
	require_once('include/actor.php');
	require_once('include/filmserie.php');
	require_once('include/pd.php');
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
			<br>
			<div id="last">
				<h3>Lo último en Moviepedia</h3>
				<div class="print" id="pdAndCast">
					<p>Último actor o actriz en aparecer en <i>Moviepedia:</i></p>
					<?php
						$actor = Actor::lastActor();
						if($actor){
							$actorName = $actor->name();
							echo <<< END
							<p style="font-weight: bold">$actorName</p>
							END;
						}
						else{
							echo '<p class="red-error">No hay actores o actrices aún insertados en la base de datos</p>';
						}
					?>
				</div>
				<!------------------------------------------------------------------------------------------------------------------>
				<div class="print" id="pdAndCast">
					<p>Última película o serie en aparecer en <i>Moviepedia:</i></p>
					<?php
						$movie = Filmserie::lastFilmserie();
						if($movie){
							$movieName = $movie->title();
							echo <<< END
							<p style="font-weight: bold">$movieName</p>
							END;
						}
						else{
							echo '<p class="red-error">No hay películas o series aún insertadas en la base de datos</p>';
						}
					?>
				</div>
				<!------------------------------------------------------------------------------------------------------------------>
				<div class="print" id="pdAndCast">
					<p>Último director en aparecer en <i>Moviepedia:</i></p>
					<?php
						$pd = Pd::lastPd();
						if($pd){
							$pdName = $pd->name();
							echo <<< END
							<p style="font-weight: bold">$pdName</p>
							END;
						}
						else{
							echo '<p class="red-error">No hay directores aún insertados en la base de datos</p>';
						}
					?>
				</div>
			</div>	
		</div>
		<?php
			require('include/common/footer.php');
		?>
	</div>
</body>
</html>