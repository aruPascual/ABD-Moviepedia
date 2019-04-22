<?php
	require_once('include/config.php');
	require_once('include/usuario.php');
	require_once('include/filmserie.php');
	require_once('include/actor.php');
	require_once('include/pd.php');
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
			<?php
				if (!isset($_SESSION['login']) || ($_SESSION['login'] == false)) {
					echo <<< END
					<p class="red-error">¡Acceso denegado!</p>
					<p class="red-error">Este espacio está reservado para los administradores de la página.</p>
					END;
				}
				else{
					$usuario = Usuario::buscaUsuario($_SESSION['nombre']);
					$userId = $usuario->id();
					$userName = $usuario->username();
					echo <<< END
					<h3>Bienvenido a tu perfil <i>$userName</i> </h3>
					END;
					/*------------------------------------------------------------------------------------------------*/
					$FilmRated = Filmserie::rated($userId);
					if (!$FilmRated) {
						echo 'Todavía no has valorado ninguna película o serie.';
					}
					else {
						echo <<< END
						<div class="print" id="PoS">
						<h4>Tus películas y series valoradas</h4>
						<div class="print" id="listCast">
						END;
						foreach ($FilmRated as $key => $value) {
							echo <<< END
							<p class="label">- $value[0]: $value[1] <i class="fas fa-heart" style="color: red;"></i></p>
							END;
						}
						echo <<< END
						</div>
						</div>
						END;
					}
					/*------------------------------------------------------------------------------------------------*/
					$ActorRated = Actor::rated($userId);
					if (!$ActorRated) {
						echo 'Todavía no has valorado ningún actor o actriz.';
					}
					else {
						echo <<< END
						<div class="print" id="Actor">
						<h4>Tus actores y actrices valorados</h4>
						<div class="print" id="listCast">
						END;
						foreach ($ActorRated as $key => $value) {
							echo <<< END
							<p class="label">- $value[0]: $value[1] <i class="fas fa-heart" style="color: red;"></i></p>
							END;
						}
						echo <<< END
						</div>
						</div>
						END;
					}
					/*------------------------------------------------------------------------------------------------*/
					$PdRated = Pd::rated($userId);
					if (!$PdRated) {
						echo 'Todavía no has valorado ningún director.';
					}
					else {
						echo <<< END
						<div class="print" id="Pd">
						<h4>Tus directores valorados</h4>
						<div class="print" id="listCast">
						END;
						foreach ($PdRated as $key => $value) {
							echo <<< END
							<p class="label">- $value[0]: $value[1] <i class="fas fa-heart" style="color: red;"></i></p>
							END;
						}
						echo <<< END
						</div>
						</div>
						END;
					}
				}
			?>
		</div>
		<?php
			require('include/common/footer.php');
		?>
	</div>
</body>
</html>