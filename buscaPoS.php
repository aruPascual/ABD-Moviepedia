<?php
	require_once("include/config.php");
	require_once("include/searchPoSForm.php");
	require_once("include/filmserie.php");

	require_once("include/usuario.php");
	if (isset($_POST['save']) && (isset($_SESSION['login'])) && ($_SESSION['login'] == true)) {

		$usuario = Usuario::buscaUsuario($_SESSION['nombre']);
		$usuarioId = $usuario->id();
		$movie = FilmSerie::searchFilmserie($_POST['filmName']);
		$movieId = $movie->id();
		$ratedIndex = $_POST['ratedIndexPoS'];
		$ratedIndex++;

		$app = Aplicacion::getInstance();
		$conn = $app->conexionBD();

		$query = sprintf("SELECT * FROM ratingfos WHERE idUser = '%d' AND idFilm = '%d'"
			, $conn->real_escape_string($usuarioId)
			, $conn->real_escape_string($movieId));
		$rs = $conn->query($query);
		if ($conn->affected_rows == 0) {
			$query = sprintf("INSERT INTO ratingfos(idUser, idFilm, rating) VALUES ('%d', '%d', '%d')"
				, $conn->real_escape_string($usuarioId)
				, $conn->real_escape_string($movieId)
				, $conn->real_escape_string($ratedIndex));
			if (!$conn->query($query)) {
				echo "<p class='red-error'>Error al insertar la valoración de una película o serie  en la BD: (". $conn->errno .") ". utf8_encode($conn->errno)."</p>";
				exit();
			}
		}else {
			$query = sprintf("UPDATE ratingfos SET rating = '%d' WHERE idUser = '%d' AND idFilm = '%d'"
				, $conn->real_escape_string($ratedIndex)
				, $conn->real_escape_string($usuarioId)
				, $conn->real_escape_string($movieId));
			if (!$conn->query($query)) {
				echo "<p class='red-error'>Error al actualizar la valoración de una película o serie en la BD: (". $conn->errno .") ". utf8_encode($conn->errno)."</p>";
				exit();
			}
		}

		exit(json_encode(array('id' => $usuarioId , 'idFilm' => $movieId )));
	}

	/* mostrar la valoración media */
	if (isset($_GET['title'])) {
		$movie = FilmSerie::searchFilmserie($_GET['title']);
		$movieId = $movie->id();

		$app = Aplicacion::getInstance();
		$conn = $app->conexionBD();

		$query = sprintf("SELECT idFilm FROM ratingfos WHERE idFilm = '%d'"
			, $conn->real_escape_string($movieId));
		$rs = $conn->query($query);
		$numR;
		if ($rs) {
			$numR = $conn->affected_rows;
		}

		$query = sprintf("SELECT SUM(rating) AS totalRating FROM ratingfos WHERE idFilm = '%d'"
			, $conn->real_escape_string($movieId));
		$rs = $conn->query($query);
		if ($rs) {
			$rData = $rs->fetch_array();
			$totalRating = $rData['totalRating'];
		}
		$avg = 0;
		if ($numR !== 0) {
			$avg = round(($totalRating / $numR), 2);
		}
	}
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
			require("include/common/header.php");
			require("include/common/topnav.php");
		?>
		<div class="content">
			<?php
				if (isset($_GET['title']) && ($_GET['title'] != null)) {
					$movie = FilmSerie::searchFilmserie($_GET['title']);
					$mTitle = $movie->title();
					$mRlsDate = $movie->releaseDate();
					$mGenre = $movie->genre();
					$mRunTime = $movie->runtime();
					$mEpisodes = $movie->episodes();

					echo <<< END
						<div class="print">
						<p class="label">Título: </p>$mTitle
						</div>
						<div class="print">
						<p class="label">Fecha de estreno: </p>$mRlsDate
						</div>
						<div class="print">
						<p class="label">Género: </p>$mGenre
						</div>
						<div class="print">
						<p class="label">Duración: </p>$mRunTime mins
						</div>
					END;
					if ($mEpisodes > 1) {
						echo <<< END
						<div class="print">
						<p class="label">Número de episodios: </p>$mEpisodes
						</div>
						END;
					}
					echo <<< END
					<div class="ratingDiv">
						<p class="label">Valoración: </p>
						<i class="fas fa-heart" data-index="0"></i>
						<i class="fas fa-heart" data-index="1"></i>
						<i class="fas fa-heart" data-index="2"></i>
						<i class="fas fa-heart" data-index="3"></i>
						<i class="fas fa-heart" data-index="4"></i>
					END;
					echo $avg.'/5';
					echo <<< END
					</div>
					END;
					FilmSerie::printPdAndCast($movie);
				}
				else{
			?>
					<h3>¿Buscas una película o una serie?</h3>
			<?php
					$formulario = new formularioBusquedaPoS("search", array('action' => 'buscaPoS.php'));
					echo $formulario->gestiona();
				}
			?>
		</div>
		<?php
			require("include/common/footer.php");
		?>
	</div>
		<script src="http://code.jquery.com/jquery-3.4.0.min.js" integrity="sha256-BJeo0qm959uMBGb65z40ejJYGSgR7REI4+CW1fNKwOg="  crossorigin="anonymous"></script>
	<script>
		var ratedIndexPoS = -1; 
		var urlParams = new URLSearchParams(window.location.search);
		var fName = urlParams.get('title');

		$(document).ready(function () {
			resetColor();

			if (localStorage.getItem('ratedIndexPoS') != null) {
				setRating(parseInt(localStorage.getItem('ratedIndexPoS')));
			}

			$('.fa-heart').on('click', function (){
				ratedIndexPoS = parseInt($(this).data('index'));
				localStorage.setItem('ratedIndexPoS', ratedIndexPoS);
				saveToBataBase();
			});

			$('.fa-heart').mouseover(function (){
				resetColor();
				var currentIndex = parseInt($(this).data('index'));
				setRating(currentIndex);
			});

			$('.fa-heart').mouseleave(function (){
				resetColor();
				if (ratedIndexPoS != -1) {
					setRating(ratedIndexPoS);
				}
			});

			function saveToBataBase(){
				$.ajax({
					url:'buscaPos.php',
					method: 'POST',
					dataType: 'json',
					data: {
						save: 1,
						filmName: fName,
						ratedIndexPoS: ratedIndexPoS
					}, success: function (r) {
						userId = r.id;
						filmId = r.idFilm;
					}
				})
			}

			function setRating(max){
				for (var i = 0; i <= max; i++) {
						$('.fa-heart:eq('+i+')').css('color', 'red');
					}
			}

			function resetColor(){
				$('.fa-heart').css('color', '#b3c2bf');
			}
		});
	</script>
</body>
</html>