<div class="topnav">
	<ul>
		<li><a href="main_page.php">Casa</a></li>
		<li><a>Búsqueda</a>
			<ul>
				<li><a href="buscaPoS.php">Buscar Películas o Series</a></li>
				<li><a href="buscaActor.php">Buscar Actores</a></li>
				<li><a href="buscaDir.php">Buscar Director</a></li>
			</ul>
		</li>
		<?php
		if (isset($_SESSION['userId'])) {
			echo '<li><a href="#" class="perfil">Perfil</a></li>
			<li><a href="logout.php" class="logout-signup">Logout</a></li>';
		}
		else{
			echo '<li><a href="login.php" class="login-signup">Login</a></li>
				<li><a href="signup.php" class="header-signup">Regístrate</a></li>';
		}
		?>
	</ul>
</div>