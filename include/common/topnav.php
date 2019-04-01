<div class="topnav">
	<ul>
		<li><a href="main_page.php">Casa</a></li>
		<li><a>Búsqueda</a>
			<ul>
				<li><a href="buscaPoS.php">Buscar Películas o Series</a></li>
				<li><a href="buscaActor.php">Buscar Actores</a></li>
				<li><a href="buscaPD.php">Buscar Director</a></li>
			</ul>
		</li>
		<?php
			if ((isset($_SESSION['login']) && ($_SESSION['login']===true))) {
				echo '<li><a href="#" class="perfil">Perfil</a></li>';
				if(($_SESSION['rol'] != 0)){
					echo '<li><a href="adminToolPage.php" class="admin">Herramienta Admin</a></li>';
				}
				echo '<li><a href="logout.php" class="logout-signup">Logout</a></li>';
			}
			else{
				echo '<li><a href="login.php" class="login-signup">Login</a></li>
					<li><a href="signup.php" class="header-signup">Regístrate</a></li>';
			}
		?>
	</ul>
</div>