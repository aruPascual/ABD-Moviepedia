<?php
	require_once("include/config.php");
	require_once("include/searchActorForm.php");
	require_once("include/actor.php");

	require_once("include/usuario.php");
	if (isset($_POST['save']) && (isset($_SESSION['login'])) && ($_SESSION['login'] == true)) {

		$usuario = Usuario::buscaUsuario($_SESSION['nombre']);
		$usuarioId = $usuario->id();
		$actor = Actor::searchActor($_POST['actorName']);
		$actorId = $actor->id();
		$ratedIndex = $_POST['ratedIndexA'];
		$ratedIndex++;

		$app = Aplicacion::getInstance();
		$conn = $app->conexionBD();

		$query = sprintf("SELECT * FROM ratingactor WHERE idUser = '%d' AND idActor = '%d'"
			, $conn->real_escape_string($usuarioId)
			, $conn->real_escape_string($actorId));
		$rs = $conn->query($query);
		if ($conn->affected_rows == 0) {
			$query = sprintf("INSERT INTO ratingactor(idUser, idActor, rating) VALUES ('%d', '%d', '%d')"
				, $conn->real_escape_string($usuarioId)
				, $conn->real_escape_string($actorId)
				, $conn->real_escape_string($ratedIndex));
			if (!$conn->query($query)) {
				echo "<p class='red-error'>Error al insertar la valoración de un actor o actriz  en la BD: (". $conn->errno .") ". utf8_encode($conn->errno)."</p>";
				exit();
			}
		}else {
			$query = sprintf("UPDATE ratingactor SET rating = '%d' WHERE idUser = '%d'AND idActor = '%d'"
				, $conn->real_escape_string($ratedIndex)
				, $conn->real_escape_string($usuarioId)
				, $conn->real_escape_string($actorId));
			if (!$conn->query($query)) {
				echo "<p class='red-error'>Error al actualizar la valoración de un actor o actriz en la BD: (". $conn->errno .") ". utf8_encode($conn->errno)."</p>";
				exit();
			}
		}

		exit(json_encode(array('id' => $usuarioId , 'idActor' => $actorId )));
	}

	/* mostrar la valoración media */
	if (isset($_GET['actorName'])) {
		$actor = Actor::searchActor($_GET['actorName']);
		$actorId = $actor->id();

		$app = Aplicacion::getInstance();
		$conn = $app->conexionBD();

		$query = sprintf("SELECT idActor FROM ratingactor WHERE idActor = '%d'"
			, $conn->real_escape_string($actorId));
		$rs = $conn->query($query);
		$numR;
		if ($rs) {
			$numR = $conn->affected_rows;
		}

		$query = sprintf("SELECT SUM(rating) AS totalRating FROM ratingactor WHERE idActor = '%d'"
			, $conn->real_escape_string($actorId));
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
				if (isset($_GET['actorName']) && ($_GET['actorName'] != null)) {
					$actor = Actor::searchActor($_GET['actorName']);
					$aName = $actor->name();
					$brthDate = $actor->birthDate();

					echo <<< END
					<div class="print">
					<p class="label">Nombre: </p>$aName
					</div>
					<div class="print">
					<p class="label">Fecha de nacimiento: </p>$brthDate
					</div>
					END;
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
					Actor::printMovies($actor);
				}
				else{
			?>
					<h3>¿Buscas a un actor o a una actriz en particular?</h3>
			<?php
					$formulario = new formularioBusquedaActor("search", array('action' => "buscaActor.php"));
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
		var ratedIndexA = -1; 
		var urlParams = new URLSearchParams(window.location.search);
		var aName = urlParams.get('actorName');

		$(document).ready(function () {
			resetColor();

			if (localStorage.getItem('ratedIndexA') != null) {
				setRating(parseInt(localStorage.getItem('ratedIndexA')));
			}

			$('.fa-heart').on('click', function (){
				ratedIndexA = parseInt($(this).data('index'));
				localStorage.setItem('ratedIndexA', ratedIndexA);
				saveToBataBase();
			});

			$('.fa-heart').mouseover(function (){
				resetColor();
				var currentIndex = parseInt($(this).data('index'));
				setRating(currentIndex);
			});

			$('.fa-heart').mouseleave(function (){
				resetColor();
				if (ratedIndexA != -1) {
					setRating(ratedIndexA);
				}
			});

			function saveToBataBase(){
				$.ajax({
					url:'buscaActor.php',
					method: 'POST',
					dataType: 'json',
					data: {
						save: 1,
						actorName: aName,
						ratedIndexA: ratedIndexA
					}, success: function (r) {
						userId = r.id;
						actorId = r.idActor;
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