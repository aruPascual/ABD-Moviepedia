<?php
	require_once("include/config.php");
	require_once("include/searchPdForm.php");
	require_once("include/pd.php");

	require_once("include/usuario.php");
	if (isset($_POST['save']) && (isset($_SESSION['login'])) && ($_SESSION['login'] == true)) {

		$usuario = Usuario::buscaUsuario($_SESSION['nombre']);
		$usuarioId = $usuario->id();
		$pd = Pd::searchPd($_POST['pdName']);
		$pdId = $pd->id();
		$ratedIndex = $_POST['ratedIndexPd'];
		$ratedIndex++;

		$app = Aplicacion::getInstance();
		$conn = $app->conexionBD();

		$query = sprintf("SELECT * FROM ratingpd WHERE idUser = '%d' AND idPd = '%d'"
			, $conn->real_escape_string($usuarioId)
			, $conn->real_escape_string($pdId));
		$rs = $conn->query($query);
		if ($conn->affected_rows == 0) {
			$query = sprintf("INSERT INTO ratingpd(idUser, idPd, rating) VALUES ('%d', '%d', '%d')"
				, $conn->real_escape_string($usuarioId)
				, $conn->real_escape_string($pdId)
				, $conn->real_escape_string($ratedIndex));
			if (!$conn->query($query)) {
				echo "<p class='red-error'>Error al insertar la valoración de un director  en la BD: (". $conn->errno .") ". utf8_encode($conn->errno)."</p>";
				exit();
			}
		}else {
			$query = sprintf("UPDATE ratingpd SET rating = '%d' WHERE idUser = '%d'AND idPd = '%d'"
				, $conn->real_escape_string($ratedIndex)
				, $conn->real_escape_string($usuarioId)
				, $conn->real_escape_string($pdId));
			if (!$conn->query($query)) {
				echo "<p class='red-error'>Error al actualizar la valoración de un director en la BD: (". $conn->errno .") ". utf8_encode($conn->errno)."</p>";
				exit();
			}
		}

		exit(json_encode(array('id' => $usuarioId , 'idPd' => $pdId )));
	}

	/* mostrar la valoración media */
	if (isset($_GET['pdName'])) {
		$pd = Pd::searchPd($_GET['pdName']);
		$pdId = $pd->id();

		$app = Aplicacion::getInstance();
		$conn = $app->conexionBD();

		$query = sprintf("SELECT idPd FROM ratingpd WHERE idPd = '%d'"
			, $conn->real_escape_string($pdId));
		$rs = $conn->query($query);
		$numR;
		if ($rs) {
			$numR = $conn->affected_rows;
		}

		$query = sprintf("SELECT SUM(rating) AS totalRating FROM ratingpd WHERE idPd = '%d'"
			, $conn->real_escape_string($pdId));
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
				if (isset($_GET['pdName']) && ($_GET['pdName'] != null)) {
					$pd = Pd::searchPd($_GET['pdName']);
					$pName = $pd->name();
					$pBrthDate = $pd->birthDate();

					echo <<< END
					<div class="print">
					<p class="label">Nombre: </p>$pName
					</div>
					<div class="print">
					<p class="label">Fecha de nacimiento: </p>$pBrthDate
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
					Pd::print($pd);
				}
				else {
			?>
					<h3>¿Buscas a un director en particular?</h3>
			<?php
					$formulario = new formularioBusquedaPd("search", array('action' => "buscaPD.php"));
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
		var ratedIndexPd = -1; 
		var urlParams = new URLSearchParams(window.location.search);
		var pdName = urlParams.get('pdName');

		$(document).ready(function () {
			resetColor();

			if (localStorage.getItem('ratedIndexPd') != null) {
				setRating(parseInt(localStorage.getItem('ratedIndexPd')));
			}

			$('.fa-heart').on('click', function (){
				ratedIndexPd = parseInt($(this).data('index'));
				localStorage.setItem('ratedIndexPd', ratedIndexPd);
				saveToBataBase();
			});

			$('.fa-heart').mouseover(function (){
				resetColor();
				var currentIndex = parseInt($(this).data('index'));
				setRating(currentIndex);
			});

			$('.fa-heart').mouseleave(function (){
				resetColor();
				if (ratedIndexPd != -1) {
					setRating(ratedIndexPd);
				}
			});

			function saveToBataBase(){
				$.ajax({
					url:'buscaPd.php',
					method: 'POST',
					dataType: 'json',
					data: {
						save: 1,
						pdName: pdName,
						ratedIndexPd: ratedIndexPd
					}, success: function (r) {
						userId = r.id;
						actorId = r.idPd;
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