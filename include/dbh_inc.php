<?php

$serverName = "localhost"; /* dependerá de tu host */
$dbUsername = "root";
$dbPassword = "";
$dbName = "data_base";

$connection = mysqli_connect($serverName, $dbUsername, $dbPassword, $dbName);

if (!$connection) {
	die("Connection failed: ".mysqli_connect_error());
}