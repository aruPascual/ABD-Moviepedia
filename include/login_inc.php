<?php

if (isset($_POST['login-submit'])) {
	require 'dbh_inc.php';

	$mailuid = $_POST['userId'];
	$password = $_POST['passId'];

	if(empty($mailuid) || empty($password)){ /* comprobación */
		header("Location: ../login.php?error=emptyfields");
		exit();
	}
	else{
		/* contemplamos login con usuario o con correo */
		$sql = "SELECT * FROM users WHERE uidUsers=? OR emailUsers=?;";
		$stmt = mysqli_stmt_init($connection);
		if (!mysqli_stmt_prepare($stmt, $sql)) {
			header("Location: ../main_page.php?error=sqlerror");
			exit();
		}
		else{
			/* info que pasamos del usuario a la base de datos */
			mysqli_stmt_bind_param($stmt, "ss", $mailuid, $mailuid);
			/* ejecutamos */
			mysqli_stmt_execute($stmt);
			/* guardamos el resultado de la consulta en stmt */
			$result = mysqli_stmt_get_result($stmt);
			/* comprobamos que seleccionamos antes con el sql anterior */
			if ($row = mysqli_fetch_assoc($result)) {
				/* comprobamos que las contraseñas son iguales */
				$pwdCheck = password_verify($password, $row['pwdUsers']);
				if ($pwdCheck === false) {
					header("Location: ../login.php?error=somethingwrong");
					exit();
				}
				else if ($pwdCheck === true) {
					/* iniciamos sesión solo con el id y el nombre de usuario */
					session_start();
					$_SESSION['userId'] = $row['idUsers'];
					$_SESSION['userUid'] = $row['uidUsers'];

					header("Location: ../main_page.php?login=success");
					exit();
				}
				else{
					header("Location: ../login.php?error=somethingwrong");
					exit();
				}
			}
			else{
				header("Location: ../login.php?error=nouser");
				exit();
			}
		}
	}
}
else{
	header("Location: ../main_page.php");
	exit();
}