<?php
if (isset($_POST['signup-submit'])) {

	require 'dbh_inc.php';

	$username = $_POST['userID'];
	$usermail = $_POST['email'];
	$userpwd = $_POST['pass'];
	$pwdrepeat = $_POST['pass-repeat'];

	if (empty($username) || empty($usermail) || empty($userpwd) || empty($pwdrepeat)) { 
		/* comprobación de campos vacios */
		/* nos devuelve a la página inicial donde tendremos que rellenar de nuevo la información. 
		las variables como userID y email las devolvemos */
		header("Location: ../signup.php?error=emptyfields&userID=".$username."&email".$usermail);
		exit();
	}
	elseif (!filter_var($usermail, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username)) {
			/* comprobación simultánea de la validez del correo y contraseña */
		header("Location: ../signup.php?error=invalidmailuid");
		exit();
	}
	elseif (!filter_var($usermail, FILTER_VALIDATE_EMAIL)) {	/* comprobación de la validez del correo */
		header("Location: ../signup.php?error=invalidmail&userID=".$username);
		exit();
	}
	elseif (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {	/* comprobación de la validez de la contraseña */ 
		header("Location: ../signup.php?error=invaliduid&email=".$usermail);
		exit();
	}
	elseif ($userpwd !== $pwdrepeat) {	/* comprobación de la validez en concordancia de las dos contraseñas 
		introducidas por el usuario */
		header("Location: ../signup.php?error=passwordcheck&userID=".$username."&email=".$usermail);
		exit();
	}
	else{	/* comprobación sobre la validez del nombre elegido por el usuario */
		/* no igualamos a la variable $username para evitar que puedan código SQL en el campo de 
		texto que acabe ejecutandose en nuestra BBDD. Usamos un ?: placeholder */
		$sql = "SELECT uidUsers FROM users WHERE uidUsers=?";

		/* para evitar esto usaremos 'statements' */
		$stmt = mysqli_stmt_init($connection);
		/* lanzamos la consulta para comprobar que funciona en la base de datos y es correcta */
		if (!mysqli_stmt_prepare($stmt, $sql)) {
			header("Location: ../signup.php?error=sqlerror");
			exit();
		}
		else{
			mysqli_stmt_bind_param($stmt, "s"/*1 solo string*/, $username);
			mysqli_stmt_execute($stmt); /* envia a checkear la información a la base de datos */
			/* checkeamos si existe o no el usuario */
			mysqli_stmt_store_result($stmt); /* coge el resultado de la base de datos y lo guarda en stmt */
			$resultcheck = mysqli_stmt_num_rows($stmt); /* cuantas filas coinciden. Esperamos 0 u 1 */
			if ($resultcheck > 0) {
				/* esta repetido: mandamos de vuelta a la página de signup */
				header("Location: ../signup.php?error=usertaken&email".$usermail);
				exit();
			}
			else{
				/* no hace falta rellenar el campo de idUsers de la tabla puesto que se auto incrementa */
				$sql = "INSERT INTO users (uidUsers, emailUsers, pwdUsers) VALUES (?, ?, ?)";
				$stmt = mysqli_stmt_init($connection);
				if (!mysqli_stmt_prepare($stmt, $sql)) {
					header("Location: ../signup.php?error=sqlerror");
					exit();
				}
				else{
					$hashedPwd = password_hash($userpwd, PASSWORD_DEFAULT);

					mysqli_stmt_bind_param($stmt, "sss", $username, $usermail, $hashedPwd); /*3 string*/
					mysqli_stmt_execute($stmt);
					header("Location: ../main_page.php?signup=success");
					exit();
				}
			}
		}
	}
	mysqli_stmt_close($stmt);
	mysqli_close($connection);

}
else{
	header("Location: ../signup.php");
	exit();
}