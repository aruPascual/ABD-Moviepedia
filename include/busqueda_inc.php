<?php

if (isset($_GET['pors-search'])) {
	require 'dbh_inc.php';

	$searchType = $_GET['type'];
	$searchBy = $_GET['search-by'];
	$dataToSearch = $_GET['data'];

	if (empty($dataToSearch)) {
		header("Location: ../buscaPoS.php?error=emptyfields");
		exit;
	}
	else{

	}

	mysqli_close($connection);
	
}
else if (isset($_GET['actor-search'])) {
	require 'dbh_inc.php';

	$searchBy = $_GET['search-by'];
	$dataToSearch = $_GET['data'];

	if (empty($dataToSearch)) {
		header("Location: ../buscaActor.php?error=emptyfields");
		exit;
	}
	else{

	}

	mysqli_close($connection);

}
else if (isset($_GET['pd-search'])) {
	require 'dbh_inc.php';
	
	$searchBy = $_GET['search-by'];
	$dataToSearch = $_GET['data'];

	if (empty($dataToSearch)) {
		header("Location: ../buscaActor.php?error=emptyfields");
		exit;
	}
	else{

	}

	mysqli_close($connection);

}else{
	header("Location: ../main_page.php");
	exit();
}