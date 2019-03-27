<?php

require_once("include/config.php");
//Doble seguridad: unset + destroy
unset($_SESSION["login"]);
unset($_SESSION["esAdmin"]);
unset($_SESSION["nombre"]);
session_destroy();

header("Location: ../ABD-Moviepedia/main_page.php");